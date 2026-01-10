<?php

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
    
    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
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
            
            // 2. Handle photos upload jika ada
            if (!empty($this->listingData['photos'])) {
                foreach ($this->listingData['photos'] as $index => $photo) {
                    if (method_exists($photo, 'store')) {
                        $path = $photo->store('listings/photos', 'public');
                        
                        ListingPhoto::create([
                            'listing_id' => $listing->id,
                            'filename' => $photo->getClientOriginalName(),
                            'path' => $path,
                            'is_thumbnail' => ($index == ($this->listingData['thumbnail_index'] ?? 0)),
                            'order_index' => $index,
                        ]);
                    }
                }
            }
            
            // 3. Success
            $this->isSubmitting = false;
            session()->flash('success', 'Listing submitted successfully! Waiting for admin approval.');
            
            // Redirect to vendor dashboard
            return redirect()->route('vendor.dashboard');
            
        } catch (\Exception $e) {
            $this->isSubmitting = false;
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.vendor.steps.step4-review-submit');
    }
}