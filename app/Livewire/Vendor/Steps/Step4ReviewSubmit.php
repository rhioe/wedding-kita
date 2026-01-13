<?php
// app\Livewire\Vendor\Steps\Step4ReviewSubmit.php


namespace App\Livewire\Vendor\Steps;

use Livewire\Component;
use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Jobs\CompressListingPhotosJob;
use Illuminate\Support\Str;

class Step4ReviewSubmit extends Component
{
    protected $listeners = ['submitListing'];

    public $listingData;
    public $step;
    public $isSubmitting = false;
    public $photoPreviews = [];

    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        
        // Generate previews for display
        $this->generatePhotoPreviews();
        
        \Log::info('Step4 mounted with data:', [
            'business_name' => $this->listingData['business_name'] ?? '',
            'photos_count' => count($this->listingData['photos'] ?? []),
            'has_photos_array' => !empty($this->listingData['photos']),
            'first_photo_data' => $this->listingData['photos'][0] ?? 'none',
        ]);
    }
    
    private function generatePhotoPreviews()
    {
        $this->photoPreviews = [];
        
        if (!empty($this->listingData['photos'])) {
            foreach ($this->listingData['photos'] as $index => $photoData) {
                if (!empty($photoData['temp_path']) && Storage::disk('local')->exists($photoData['temp_path'])) {
                    // Create preview from temp file
                    $this->photoPreviews[] = [
                        'id' => 'preview_' . $index,
                        'preview' => 'data:image/jpeg;base64,' . base64_encode(
                            Storage::disk('local')->get($photoData['temp_path'])
                        ),
                        'is_thumbnail' => $index == ($this->listingData['thumbnail_index'] ?? 0),
                    ];
                }
            }
        }
    }
    
    public function submitListing()
    {
        $this->isSubmitting = true;
        
        // Use transaction for data consistency
        DB::beginTransaction();
        
        try {
            \Log::info('🔔 === VENDOR SUBMITTING LISTING ===');
            \Log::info('Vendor ID: ' . Auth::id());
            \Log::info('Photos count in data: ' . count($this->listingData['photos'] ?? []));
            
            // 1. Validate minimum photos
            if (empty($this->listingData['photos']) || count($this->listingData['photos']) < 2) {
                throw new \Exception('Minimal 2 foto diperlukan untuk listing');
            }
            
            // 2. Create listing record
            $listing = Listing::create([
                'vendor_id' => Auth::id(),
                'category_id' => $this->listingData['category_id'],
                'title' => $this->listingData['package_name'],
                'slug' => \Str::slug($this->listingData['package_name']) . '-' . time(),
                'description' => $this->listingData['description'],
                'price' => $this->listingData['price'],
                'location' => $this->listingData['location'],
                'business_name' => $this->listingData['business_name'],
                'year_established' => $this->listingData['year_established'] ?: null,
                'instagram' => $this->listingData['instagram'] ?: null,
                'website' => $this->listingData['website'] ?: null,
                'package_description' => $this->listingData['package_description'] ?: null,
                'validity_period' => $this->listingData['validity_period'] ?: null,
                'status' => 'pending',
            ]);
            
            \Log::info('✅ Listing created. ID: ' . $listing->id);
            
            // 3. Handle photo uploads
            $uploadedCount = 0;
            $photoRecords = [];
            
            foreach ($this->listingData['photos'] as $index => $photoData) {
                \Log::info("Processing photo {$index}:", [
                    'has_temp_path' => !empty($photoData['temp_path']),
                    'temp_path' => $photoData['temp_path'] ?? 'none',
                    'original_name' => $photoData['original_name'] ?? 'unknown',
                ]);
                
                if (empty($photoData['temp_path'])) {
                    \Log::warning('Skipping photo: No temp_path');
                    continue;
                }
                
                // Check which disk has the temp file
                $tempPath = $photoData['temp_path'];
                $tempDisk = 'local'; // Livewire default
                
                if (!Storage::disk($tempDisk)->exists($tempPath)) {
                    \Log::warning("File not found in {$tempDisk} disk, trying default...");
                    $tempDisk = null; // Use default
                    
                    if (!Storage::exists($tempPath)) {
                        \Log::error('Temp file not found anywhere: ' . $tempPath);
                        continue;
                    }
                }
                
                // Get file contents from correct disk
                $contents = $tempDisk 
                    ? Storage::disk($tempDisk)->get($tempPath)
                    : Storage::get($tempPath);
                
                if (empty($contents)) {
                    \Log::error('Empty file contents for: ' . $tempPath);
                    continue;
                }
                
                // Generate unique filename
                $originalName = $photoData['original_name'] ?? 'photo.jpg';
                $extension = pathinfo($originalName, PATHINFO_EXTENSION) ?: 'jpg';
                $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) 
                    . '_' . uniqid() 
                    . '.' . $extension;
                
                $finalPath = "listings/photos/original/{$listing->id}/{$filename}";
                
                // Ensure directory exists
                $directory = dirname($finalPath);
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }
                
                // Save to public disk
                $saved = Storage::disk('public')->put($finalPath, $contents);
                
                if (!$saved) {
                    \Log::error('Failed to save file to public disk: ' . $finalPath);
                    continue;
                }
                
                // Verify file was saved
                $fullPhysicalPath = storage_path('app/public/' . $finalPath);
                if (!file_exists($fullPhysicalPath)) {
                    \Log::error('File not found after save: ' . $fullPhysicalPath);
                    continue;
                }
                
                // Determine if this is thumbnail
                $isThumbnail = ($index == ($this->listingData['thumbnail_index'] ?? 0));
                
                // Create photo record
                $photoRecord = [
                    'listing_id' => $listing->id,
                    'path' => $finalPath,
                    'compressed_path' => null,
                    'original_size_kb' => round(strlen($contents) / 1024, 2),
                    'processing_status' => 'pending',
                    'is_thumbnail' => $isThumbnail,
                    'order' => $index,
                ];
                
                $photoRecords[] = $photoRecord;
                $uploadedCount++;
                
                \Log::info('✅ Photo uploaded successfully:', [
                    'index' => $index,
                    'path' => $finalPath,
                    'size_kb' => $photoRecord['original_size_kb'],
                    'is_thumbnail' => $isThumbnail,
                ]);
                
                // Clean up temp file
                try {
                    if ($tempDisk) {
                        Storage::disk($tempDisk)->delete($tempPath);
                    } else {
                        Storage::delete($tempPath);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Could not delete temp file: ' . $e->getMessage());
                }
            }
            
            // Save all photo records to database
            if (!empty($photoRecords)) {
                ListingPhoto::insert($photoRecords);
                \Log::info("📊 {$uploadedCount}/" . count($this->listingData['photos']) . " photos saved to database");
                
                // === STEP 4: PROCESS PHOTOS COMPRESSION SYNC ===
                try {
                    \Log::info('🔄 Starting SYNC photo compression for listing #' . $listing->id);
                    
                    $photoProcessingService = app(\App\Services\PhotoProcessingService::class);
                    $compressedCount = 0;
                    $totalPhotos = $uploadedCount;
                    
                    // Get all photos for this listing
                    $photos = ListingPhoto::where('listing_id', $listing->id)->get();
                    
                    foreach ($photos as $index => $photo) {
                        \Log::info("Processing photo {$index}/{$totalPhotos}: ID {$photo->id}");
                        
                        $result = $photoProcessingService->processExistingPhoto($photo);
                        
                        if ($result['success']) {
                            $compressedCount++;
                            \Log::info("✅ Photo {$photo->id} compressed to {$result['compressed_size_kb']}KB");
                        } else {
                            \Log::warning("⚠️ Photo {$photo->id} compression failed: " . ($result['error'] ?? 'Unknown error'));
                        }
                    }
                    
                    \Log::info("📊 Compression summary: {$compressedCount}/{$totalPhotos} photos compressed");
                    
                    if ($compressedCount > 0) {
                        // Add compression info to success message
                        $compressionMessage = " ({$compressedCount} foto dioptimasi)";
                    } else {
                        $compressionMessage = "";
                    }
                    
                } catch (\Exception $e) {
                    \Log::error('Photo compression error: ' . $e->getMessage());
                    $compressionMessage = " (proses optimasi foto sedang berjalan)";
                }
                
            } else {
                throw new \Exception('Tidak ada foto yang berhasil diupload');
            }

// 5. Commit transaction
DB::commit();

// 6. Clear session backup
session()->forget('temp_photos_backup');

// 7. SUCCESS
$this->isSubmitting = false;
session()->flash('success', 'Listing berhasil dikirim! 🎉' . ($compressionMessage ?? ''));

return redirect()->route('vendor.dashboard')->with([
    'success' => 'Listing berhasil dikirim! 🎉' . ($compressionMessage ?? ''),
    'listing_id' => $listing->id,
]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('❌ CRITICAL SUBMIT ERROR: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            $this->isSubmitting = false;
            
            session()->flash('error', 'Gagal mengirim listing: ' . $e->getMessage());
            
            return back()->withErrors(['submit' => $e->getMessage()]);
        }
    }
    
    public function formatPrice($price)
    {
        if (empty($price)) return 'Rp 0';
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    
    public function getCategoryName($categoryId)
    {
        $category = \App\Models\Category::find($categoryId);
        return $category ? $category->name : 'Tidak diketahui';
    }

    public function editStep($targetStep)
    {
        $this->dispatch('goToStep', step: $targetStep);
    }
    
    public function render()
    {
        return view('livewire.vendor.steps.step4-review-submit', [
            'photoPreviews' => $this->photoPreviews,
        ]);
    }
}