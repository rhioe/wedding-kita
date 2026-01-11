<?php
// app\Services\ImageCompressorService.php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageCompressorService
{
    protected $manager;
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }
    
    /**
     * Compress image to max 120KB
     */
    public function compressToMax120KB($imagePath, $maxSizeKB = 120)
    {
        try {
            // Read image
            $image = $this->manager->read($imagePath);
            
            // Get original dimensions
            $width = $image->width();
            $height = $image->height();
            
            Log::info("Original image: {$width}x{$height}, " . round(filesize($imagePath) / 1024) . "KB");
            
            // Step 1: Scale down if too large
            if ($width > 2000 || $height > 2000) {
                $image->scaleDown(width: 1200, height: 1200);
                Log::info("Scaled down to: {$image->width()}x{$image->height()}");
            }
            
            // Step 2: Optimize quality iteratively
            $quality = 85;
            $attempts = 0;
            $encoded = null;
            $finalSizeKB = 0;
            
            do {
                // Encode with current quality
                $encoded = $image->encodeByMediaType(quality: $quality);
                $sizeKB = strlen((string) $encoded) / 1024;
                $finalSizeKB = $sizeKB;
                
                Log::info("Attempt {$attempts}: quality={$quality}, size={$sizeKB}KB");
                
                // Reduce quality if still too large
                if ($sizeKB > $maxSizeKB && $quality > 40) {
                    $quality -= 10;
                }
                
                $attempts++;
            } while ($sizeKB > $maxSizeKB && $quality > 40 && $attempts < 5);
            
            // Step 3: If still too large, resize more aggressively
            if ($finalSizeKB > $maxSizeKB) {
                Log::info("Still too large ({$finalSizeKB}KB), resizing to 800px");
                $image->scaleDown(width: 800, height: 800);
                $encoded = $image->encodeByMediaType(quality: 75);
                $finalSizeKB = strlen((string) $encoded) / 1024;
            }
            
            Log::info("Final compressed size: {$finalSizeKB}KB");
            
            return [
                'data' => $encoded,
                'size_kb' => $finalSizeKB,
                'quality' => $quality
            ];
            
        } catch (\Exception $e) {
            Log::error("Image compression failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Save compressed image to storage
     */
    public function saveCompressed($tempImagePath, $originalFilename)
    {
        try {
            // Generate unique filename
            $originalName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
            $safeName = \Str::slug($originalName);
            $uniqueName = $safeName . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            $path = 'listings/photos/' . $uniqueName;
            $fullPath = storage_path('app/public/' . $path);
            
            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Compress image
            $result = $this->compressToMax120KB($tempImagePath);
            
            // Save to file
            if ($result['data']) {
                file_put_contents($fullPath, (string) $result['data']);
                
                // Verify file was saved
                if (file_exists($fullPath)) {
                    $savedSize = filesize($fullPath) / 1024;
                    Log::info("Image saved: {$path} ({$savedSize}KB, quality: {$result['quality']})");
                    
                    // Clean up temp file
                    if (file_exists($tempImagePath)) {
                        unlink($tempImagePath);
                    }
                    
                    return $path;
                }
            }
            
            throw new \Exception("Failed to save compressed image");
            
        } catch (\Exception $e) {
            Log::error("Save compressed image failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Create thumbnail version (for future use)
     */
    public function createThumbnail($imagePath, $width = 300, $height = 300)
    {
        try {
            $image = $this->manager->read($imagePath);
            $image->cover($width, $height);
            
            return $image->encodeByMediaType(quality: 80);
        } catch (\Exception $e) {
            Log::error("Thumbnail creation failed: " . $e->getMessage());
            return null;
        }
    }
}