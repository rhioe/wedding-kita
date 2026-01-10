<?php

namespace App\Livewire\Vendor\Listings;

use Livewire\Component;

class CreateListing extends Component
{
    public $currentStep = 1;
    public $listingData = [];
    
    // Event listeners untuk data sync
    protected $listeners = [
        'goNextStep' => 'nextStep',
        'goPreviousStep' => 'previousStep',
        'step1-updated' => 'saveStep1Data',
        'step2-updated' => 'saveStep2Data',
        'step3-updated' => 'saveStep3Data',
        'step-validated' => 'handleStepValidated',
    ];

    public function handleStepValidated($stepNumber)
    {
        \Log::info("Step {$stepNumber} validated successfully");
        
        // Auto next step jika validated
        if ($stepNumber == $this->currentStep) {
            $this->nextStep();
        }
    }

    public function mount()
    {
        $this->listingData = [
            // Step 1
            'business_name' => '',
            'category_id' => '',
            'location' => '',
            'description' => '',
            'year_established' => '',
            'instagram' => '',
            'website' => '',
            
            // Step 2
            'photos' => [],
            'thumbnail_index' => 0,
            
            // Step 3
            'package_name' => '',
            'price' => '',
            'package_description' => '',
            'validity_period' => '',
        ];
    }
    
    // Navigation methods
    public function nextStep()
    {
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
    
    // Data sync methods
    public function saveStep1Data($stepData)
    {
        $this->listingData = array_merge($this->listingData, $stepData);
        \Log::info('Step 1 data saved to parent', $stepData);
    }
    
    public function saveStep2Data($stepData)
    {
        $this->listingData = array_merge($this->listingData, $stepData);
        \Log::info('Step 2 data saved to parent', ['photos_count' => count($stepData['photos'] ?? [])]);
    }
    
    public function saveStep3Data($stepData)
    {
        $this->listingData = array_merge($this->listingData, $stepData);
        \Log::info('Step 3 data saved to parent', $stepData);
    }
    
    public function render()
    {
        return view('livewire.vendor.listings.create-listing', [
            'listingData' => $this->listingData,
            'currentStep' => $this->currentStep,
        ]);
    }
}