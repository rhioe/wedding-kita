<?php
// app/Livewire/Vendor/Steps/Step4ReviewSubmit.php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;
use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Jobs\CompressListingPhotosJob;


class Step4ReviewSubmit extends Component
{
    use WithFileUploads;
    
    protected $listeners = ['submitListing'];

    public $listingData;
    public $step;
    public $isSubmitting = false;
    
    // Untuk menampilkan preview foto
    public $photoPreviews = [];

    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        
        // Load photo previews
        $this->photoPreviews = $this->listingData['photos'] ?? [];
    }
    
    public function submitListing()
    {

        \Log::error('🔥🔥 SUBMIT LISTING METHOD HIT 🔥🔥');
        $this->isSubmitting = true;
        
        try {
            \Log::info('=== VENDOR SUBMITTING LISTING ===');
            \Log::info('Vendor ID: ' . Auth::id());
            \Log::info('Data check:', [
                'business_name' => $this->listingData['business_name'] ?? 'EMPTY',
                'category_id' => $this->listingData['category_id'] ?? 'EMPTY',
                'package_name' => $this->listingData['package_name'] ?? 'EMPTY',
                'price' => $this->listingData['price'] ?? 'EMPTY',
                'photos_count' => count($this->listingData['photos'] ?? [])
            ]);
            
            // 1. Create listing record
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
            
            // 2. Handle photos - UPLOAD ORIGINAL TO STORAGE
            if (!empty($this->listingData['photos'])) {
                $uploadedCount = 0;
                
                foreach ($this->listingData['photos'] as $index => $photoData) {
                    try {
                        // Determine if this is thumbnail
                        $isThumbnail = false;
                        if (isset($this->listingData['thumbnail_index'])) {
                            $isThumbnail = ($index == $this->listingData['thumbnail_index']);
                        } elseif (isset($this->listingData['thumbnail_id'])) {
                            $isThumbnail = ($photoData['id'] ?? '') === ($this->listingData['thumbnail_id'] ?? '');
                        }
                        
                        // SIMPLE CHECK: Jika ada file object dengan method store
                        if (isset($photoData['file']) && 
                            is_object($photoData['file']) && 
                            method_exists($photoData['file'], 'store')) {
                            
                            $file = $photoData['file'];
                            
                            // Upload to storage
                            $originalPath = $file->store(
                                'listings/photos/original/' . $listing->id,
                                'public'
                            );
                            
                            // Save to database
                            ListingPhoto::create([
                                'listing_id' => $listing->id,
                                'path' => $originalPath,
                                'compressed_path' => null,
                                'original_size_kb' => round($file->getSize() / 1024, 2),
                                'processing_status' => 'pending',
                                'is_thumbnail' => $isThumbnail,
                                'order' => $index,
                            ]);
                            
                            $uploadedCount++;
                            \Log::info('✅ Photo uploaded: ' . $originalPath);
                            
                        } else {
                            // File tidak valid
                            \Log::warning('❌ Invalid file at index ' . $index, [
                                'has_file' => isset($photoData['file']),
                                'type' => isset($photoData['file']) ? gettype($photoData['file']) : 'none'
                            ]);
                            
                            // Save placeholder untuk keep order
                            ListingPhoto::create([
                                'listing_id' => $listing->id,
                                'path' => 'missing/' . ($photoData['name'] ?? 'photo_' . $index),
                                'processing_status' => 'failed',
                                'is_thumbnail' => $isThumbnail,
                                'order' => $index,
                            ]);
                        }
                        
                    } catch (\Exception $e) {
                        \Log::error('❌ Failed to process photo at index ' . $index . ': ' . $e->getMessage());
                    }
                }
                
                \Log::info('📊 Photo upload summary: ' . $uploadedCount . '/' . count($this->listingData['photos']) . ' uploaded');
            }
            
            // 3. SUCCESS - Set flash session dan redirect
            \Log::info('🎉 Listing submission successful! Redirecting to vendor dashboard...');

            $this->isSubmitting = false;

            // 🔥 DISPATCH BACKGROUND JOB untuk compress photos
            try {
                CompressListingPhotosJob::dispatch($listing->id);
                \Log::info('✅ Compression job dispatched for listing #' . $listing->id);
                
                // Pesan untuk vendor
                session()->flash('success', 
                    'Listing berhasil dikirim! 🎉 ' . 
                    'Foto sedang dioptimasi... ' .
                    'Admin akan review segera.'
                );
                
            } catch (\Exception $e) {
                \Log::error('❌ Failed to dispatch compression job', [
                    'listing_id' => $listing->id,
                    'error' => $e->getMessage()
                ]);
                
                // Tetap sukses, tapi kasih info
                session()->flash('success', 
                    'Listing berhasil dikirim! 🎉 ' .
                    '(Photo optimization will run shortly)'
                );
            }

            // Redirect ke vendor dashboard
            return redirect()->route('vendor.dashboard');
            
        } catch (\Exception $e) {
            \Log::error('❌ SUBMIT LISTING ERROR: ' . $e->getMessage());
            \Log::error('Error Trace: ' . $e->getTraceAsString());
            
            $this->isSubmitting = false;
            
            // Set error message
            session()->flash('error', 'Gagal mengirim listing: ' . $e->getMessage());
            
            // Tetap di halaman ini, tampilkan error
            return;
        }
    }
    
    // Helper untuk format harga
    public function formatPrice($price)
    {
        if (empty($price)) return 'Rp 0';
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    
    // Helper untuk get category name
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
        return view('livewire.vendor.steps.step4-review-submit');
    }
}