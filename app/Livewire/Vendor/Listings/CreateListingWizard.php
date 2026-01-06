<?php

namespace App\Livewire\Vendor\Listings;

use Livewire\Component;
use App\Models\Category;

class CreateListingWizard extends Component
{
    // Step management
    public $currentStep = 1;
    public $totalSteps = 4;
    
    // Step 1: Business Information
    public $business_name = '';
    public $category_id = '';
    public $location = '';
    public $description = '';
    public $year_established = '';
    public $instagram = '';
    public $website = '';
    
    // Step 2: Photos (placeholder)
    public $photos = [];
    public $thumbnailIndex = 0;
    
    // Step 3: Package & Pricing
    public $package_name = '';
    public $price_input = '';
    public $package_description = '';
    public $validity_period = '';
    public $terms_accepted = false;
    
    // Computed properties
    public function getCategoriesProperty()
    {
        try {
            // Pastikan return data yang benar untuk dropdown
            $categories = Category::orderBy('order')->get();
            
            // Jika kosong, buat dummy
            if ($categories->isEmpty()) {
                return collect([
                    (object) ['id' => 1, 'name' => 'Fotografer Pernikahan'],
                    (object) ['id' => 2, 'name' => 'Venue / Gedung'],
                    (object) ['id' => 3, 'name' => 'Catering & Prasmanan'],
                    (object) ['id' => 4, 'name' => 'Dekorasi & Florist'],
                    (object) ['id' => 5, 'name' => 'Makeup Artist'],
                ]);
            }
            
            return $categories;
        } catch (\Exception $e) {
            // Fallback ke dummy data
            return collect([
                (object) ['id' => 1, 'name' => 'Fotografer Pernikahan'],
                (object) ['id' => 2, 'name' => 'Venue / Gedung'],
                (object) ['id' => 3, 'name' => 'Catering & Prasmanan'],
                (object) ['id' => 4, 'name' => 'Dekorasi & Florist'],
                (object) ['id' => 5, 'name' => 'Makeup Artist'],
            ]);
        }
    }
    
    public function getFormattedPhoneProperty()
    {
        return auth()->user()->phone ?? '6281234567890';
    }
    
    public function getWhatsAppLinkProperty()
    {
        return "https://wa.me/" . $this->formattedPhone;
    }
    
    // Navigation methods
    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
    
    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            // Debug: log data sebelum validasi
            \Log::info('Step 1 Validation Data', [
                'business_name' => $this->business_name,
                'category_id' => $this->category_id,
                'location' => $this->location,
                'description' => $this->description,
                'description_length' => strlen($this->description),
            ]);
            
            $this->validate([
                'business_name' => 'required|min:3|max:100',
                'category_id' => 'required', // HAPUS exists:categories,id untuk sementara
                'location' => 'required|min:3|max:100',
                'description' => 'required|string|min:50|max:2000',
            ], [
                'description.required' => 'Deskripsi bisnis wajib diisi',
                'description.min' => 'Deskripsi minimal 50 karakter (sekarang: ' . (strlen($this->description) ?: '0') . ' karakter)',
                'description.string' => 'Deskripsi harus berupa teks',
                'category_id.required' => 'Pilih kategori bisnis',
            ]);
        }
        // Validasi step lain akan ditambah nanti
    }
    
    // Helper untuk debugging
    public function testValidation()
    {
        $this->validate([
            'description' => 'required|min:50|max:2000',
        ]);
        
        return 'Validation passed!';
    }
    
    public function render()
    {
        return view('livewire.vendor.listings.create-listing-wizard')
            ->layout('layouts.vendor', [
                'title' => 'Buat Listing Baru',
                'vendor' => auth()->user()->vendor ?? null
            ]);
    }
}