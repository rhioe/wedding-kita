<?php
// app/Services/PhotoProcessingService.php

namespace App\Services;

use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PhotoProcessingService
{
    protected $imageCompressor;

    public function __construct(ImageCompressorService $imageCompressor)
    {
        $this->imageCompressor = $imageCompressor;
    }

    /**
     * Process single photo: move from temp to storage + compress
     * Atomic operation dengan transaction safety
     */
    public function processPhoto($tempPath, $originalFilename, $listingId, $order): array
    {
        Log::info("Processing photo: {$originalFilename} for listing {$listingId}");
        
        DB::beginTransaction();
        
        try {
            // === STEP 1: Save original file ===
            $originalPath = $this->saveOriginalFile($tempPath, $originalFilename, $listingId);
            
            // === STEP 2: Save to database (masih dengan original_path) ===
            $photo = $this->createPhotoRecord($originalPath, $originalFilename, $listingId, $order);
            
            DB::commit();
            
            Log::info("Photo record created: ID {$photo->id}");
            
            // === STEP 3: Compress image (outside transaction) ===
            $compressionResult = $this->compressAndUpdate($photo);
            
            return [
                'success' => true,
                'photo_id' => $photo->id,
                'compressed_path' => $photo->compressed_path,
                'status' => $photo->status
            ];
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Photo processing failed: " . $e->getMessage());
            
            // Cleanup: delete original file if it was saved
            if (isset($originalPath) && Storage::exists($originalPath)) {
                Storage::delete($originalPath);
            }
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Save original file to storage
     */
    private function saveOriginalFile($tempPath, $filename, $listingId): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $safeName = \Str::slug(pathinfo($filename, PATHINFO_FILENAME));
        $uniqueName = $safeName . '_' . time() . '_' . uniqid() . '.' . $extension;
        
        $originalPath = "listings/photos/original/{$listingId}/{$uniqueName}";
        
        // Ensure directory exists first
        $directory = dirname(storage_path('app/public/' . $originalPath));
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Copy file from temp to permanent storage
        copy($tempPath, storage_path('app/public/' . $originalPath));
        
        Log::info("Original file saved: {$originalPath}");
        
        return $originalPath;
    }

    /**
     * Create photo record in database
     */
    private function createPhotoRecord($path, $filename, $listingId, $order): ListingPhoto
    {
        $originalSizeKB = Storage::disk('public')->size($path) / 1024;
        
        $photo = ListingPhoto::create([
            'listing_id' => $listingId,
            'path' => $path,  // original_path di database disebut 'path'
            'compressed_path' => null,
            'processing_status' => ListingPhoto::STATUS_PENDING, // pakai 'processing_status'
            'order' => $order,
            'original_size_kb' => round($originalSizeKB, 2),
            'is_thumbnail' => false
        ]);
        
        return $photo;
    }

    /**
     * Compress image and update database record
     */
    private function compressAndUpdate(ListingPhoto $photo): bool
    {
        try {
            $originalFullPath = storage_path('app/public/' . $photo->path);
            
            if (!file_exists($originalFullPath)) {
                throw new \Exception("Original file not found: {$photo->path}");
            }
            
            // === STEP 1: Compress image ===
            Log::info("Starting compression for photo ID: {$photo->id}");
            
            $compressor = new \App\Services\ImageCompressorService();
            $compressedData = $compressor->compressToMax120KB($originalFullPath);
            
            // === STEP 2: Save compressed file ===
            $compressedPath = $this->saveCompressedFile($compressedData['data'], $photo->listing_id, $photo->id);
            
            // === STEP 3: Verify compressed file is valid ===
            $this->verifyCompressedFile($compressedPath);
            
            // === STEP 4: Update database (set compressed_path) ===
            $photo->update([
                'compressed_path' => $compressedPath,
                'processing_status' => ListingPhoto::STATUS_COMPLETED,
                'compressed_size_kb' => $compressedData['size_kb']
            ]);
            
            // === STEP 5: Delete original file (after DB update successful) ===
            $originalFilePath = 'public/' . $photo->path;
            if (Storage::exists($originalFilePath)) {
                Storage::delete($originalFilePath);
                Log::info("Original file deleted: {$photo->path}");
            } else {
                Log::warning("Original file not found for deletion: {$photo->path}");
            }
            
            // === STEP 6: JANGAN set path = null (column NOT NULL) ===
            // Biarkan path di database, meskipun file sudah dihapus
            // Kita akan pakai compressed_path untuk display
            // Path original hanya untuk reference/audit trail
            
            Log::info("Photo compression completed: ID {$photo->id}, size: {$compressedData['size_kb']}KB");
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Compression failed for photo ID {$photo->id}: " . $e->getMessage());
            
            // Update status to failed, JANGAN set path = null
            $photo->update([
                'processing_status' => ListingPhoto::STATUS_FAILED
            ]);
            
            return false;
        }
    }

    /**
     * Save compressed data to storage
     */
    private function saveCompressedFile($compressedData, $listingId, $photoId): string
    {
        $compressedPath = "listings/photos/compressed/{$listingId}/photo_{$photoId}_" . time() . '.jpg';
        $fullPath = storage_path('app/public/' . $compressedPath);
        
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        file_put_contents($fullPath, $compressedData);
        
        return $compressedPath;
    }

    /**
     * Verify compressed file is valid
     */
    private function verifyCompressedFile($compressedPath): void
    {
        $fullPath = storage_path('app/public/' . $compressedPath);
        
        if (!file_exists($fullPath)) {
            throw new \Exception("Compressed file was not created");
        }
        
        $fileSize = filesize($fullPath) / 1024; // KB
        
        if ($fileSize < 10) { // Less than 10KB probably corrupted
            throw new \Exception("Compressed file is too small ({$fileSize}KB), likely corrupted");
        }
        
        if ($fileSize > 200) { // More than 200KB - compression failed
            throw new \Exception("Compressed file is too large ({$fileSize}KB), compression failed");
        }
    }

    /**
 * Process existing photo from database (for sync compression after listing submit)
 */
    public function processExistingPhoto(ListingPhoto $photo): array
    {
        try {
            $originalFullPath = storage_path('app/public/' . $photo->path);
            
            if (!file_exists($originalFullPath)) {
                throw new \Exception("Original file not found: {$photo->path}");
            }
            
            Log::info("Processing existing photo ID: {$photo->id}");
            
            // === STEP 1: Compress image ===
            $compressor = new \App\Services\ImageCompressorService();
            $compressedData = $compressor->compressToMax120KB($originalFullPath);
            
            // === STEP 2: Save compressed file ===
            $extension = 'jpg';
            $compressedPath = "listings/photos/compressed/{$photo->listing_id}/photo_{$photo->id}_" . time() . '.' . $extension;
            $fullPath = storage_path('app/public/' . $compressedPath);
            
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            file_put_contents($fullPath, $compressedData['data']);
            
            // === STEP 3: Verify compressed file is valid ===
            if (!file_exists($fullPath) || filesize($fullPath) < 10240) {
                throw new \Exception("Compressed file invalid or too small");
            }
            
            // === STEP 4: Update database ===
            $photo->update([
                'compressed_path' => $compressedPath,
                'processing_status' => ListingPhoto::STATUS_COMPLETED,
                'compressed_size_kb' => $compressedData['size_kb']
            ]);
            
            // === STEP 5: Delete original file (FIXED) ===
            if (file_exists($originalFullPath)) {
                unlink($originalFullPath);
                Log::info("Original file deleted: {$photo->path}");
            } else {
                Log::warning("Original file not found for deletion: {$photo->path}");
            }
            
            Log::info("Existing photo processed: ID {$photo->id}, size: {$compressedData['size_kb']}KB");
            
            return [
                'success' => true,
                'photo_id' => $photo->id,
                'compressed_path' => $compressedPath,
                'compressed_size_kb' => $compressedData['size_kb']
            ];
            
        } catch (\Exception $e) {
            Log::error("Process existing photo failed ID {$photo->id}: " . $e->getMessage());
            
            $photo->update([
                'processing_status' => ListingPhoto::STATUS_FAILED
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

}