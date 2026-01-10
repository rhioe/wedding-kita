<?php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Step3PackagePricing extends Component
{
    public $listingData;
    public $step;
    
    public $package_name = '';
    public $price = '';
    public $package_description = '';
    public $validity_period = '';
    
    protected $listeners = ['validate-step-3' => 'validateStep'];
    
    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        
        // Load data dari parent
        $this->package_name = $listingData['package_name'] ?? '';
        $this->price = $listingData['price'] ?? '';
        $this->package_description = $listingData['package_description'] ?? '';
        $this->validity_period = $listingData['validity_period'] ?? '';
    }
    
    public function updated($propertyName)
    {
        $this->syncToParent();
    }
    
    public function syncToParent()
    {
        $stepData = [
            'package_name' => $this->package_name,
            'price' => $this->price,
            'package_description' => $this->package_description,
            'validity_period' => $this->validity_period,
        ];
        
        $this->dispatch('step3-updated', $stepData);
        Log::info('Step 3 data synced', $stepData);
    }
    
    public function validateStep()
    {
        $this->validate([
            'package_name' => 'required|min:3|max:100',
            'price' => 'required|numeric|min:1000',
            'package_description' => 'nullable|max:1000',
            'validity_period' => 'nullable|max:50',
        ], [
            'package_name.required' => 'Nama paket wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.min' => 'Harga minimal Rp 1.000',
        ]);
        
        $this->syncToParent();
        $this->dispatch('step-validated', 3);
        return true;
    }
    
    public function render()
    {
        return view('livewire.vendor.steps.step3-package-pricing');
    }
}