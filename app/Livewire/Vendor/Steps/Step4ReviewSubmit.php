<?php
// app\Livewire\Vendor\Steps\Step4ReviewSubmit.php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;
use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Step4ReviewSubmit extends Component
{
    use WithFileUploads;
    
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
        $this->isSubmitting = true;
        
        try {
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
            
            // 2. Handle photos - PERUBAHAN DI SINI
            // Photos sudah berupa metadata array, bukan file objects
            if (!empty($this->listingData['photos'])) {
                foreach ($this->listingData['photos'] as $index => $photoMeta) {
                    // Untuk demo, kita simpan info saja
                    // Di production, Anda perlu handle file upload dari temporary storage
                    
                    ListingPhoto::create([
                        'listing_id' => $listing->id,
                        'path' => $photoMeta['preview'] ?? 'temp/path', // Temporary path
                        'is_thumbnail' => ($photoMeta['id'] === ($this->listingData['thumbnail_id'] ?? '')),
                        'order' => $index,
                    ]);
                }
            }
            
            // 3. Success
            $this->isSubmitting = false;
            session()->flash('success', 'Listing berhasil dikirim! Menunggu persetujuan admin.');
            
            return redirect()->route('vendor.dashboard');
            
        } catch (\Exception $e) {
            $this->isSubmitting = false;
            session()->flash('error', 'Error: ' . $e->getMessage());
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