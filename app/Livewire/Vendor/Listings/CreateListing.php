<?php
// app\Livewire\Vendor\Listings\CreateListing.php


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
        'goToStep' => 'goToStep', 
        'step1-updated' => 'saveStep1Data',
        'step2-updated' => 'saveStep2Data',
        'step3-updated' => 'saveStep3Data',
        'step-validated' => 'handleStepValidated',
    ];

    public function goToStep($payload)
    {
        $step = is_array($payload) ? $payload[0] : $payload;

        if ($step >= 1 && $step <= 4) {

            if ($step == 3) {
                $this->dispatch('load-step3-data', $this->listingData);
            }

            $this->currentStep = $step;
        }
    }



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
        // Dispatch data ke step sebelumnya SEBELUM pindah
        $this->dispatch('load-step3-data', $this->listingData);
        
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
    // Hapus titik dari harga jika ada
    if (isset($stepData['price']) && is_string($stepData['price'])) {
        $stepData['price'] = str_replace('.', '', $stepData['price']);
    }
    
    $this->listingData = array_merge($this->listingData, $stepData);
}

    
    public function render()
    {
        return view('livewire.vendor.listings.create-listing', [
            'listingData' => $this->listingData,
            'currentStep' => $this->currentStep,
        ]);
    }
}