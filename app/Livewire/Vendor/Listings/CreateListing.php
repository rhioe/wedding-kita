<?php

// app\Livewire\Vendor\Listings\CreateListing.php

namespace App\Livewire\Vendor\Listings;

use Livewire\Component;

class CreateListing extends Component
{
    public $currentStep = 1;

    public $listingData = [];

    // Event listeners
    protected $listeners = [
        'goNextStep' => 'nextStep',
        'goPreviousStep' => 'previousStep',
        'goToStep' => 'goToStep',
        'step1-updated' => 'saveStep1Data',
        'step2-updated' => 'saveStep2Data', // ✅ UPDATE METHOD INI
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
            'photos' => [], // ✅ AKAN BERISI TEMP PATHS
            'thumbnail_index' => 0,

            // Step 3
            'package_name' => '',
            'price' => '',
            'package_description' => '',
            'validity_period' => '',
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->dispatch('load-step3-data', $this->listingData);
            $this->currentStep--;
        }
    }

    public function saveStep1Data($stepData)
    {
        $this->listingData = array_merge($this->listingData, $stepData);
    }

    public function saveStep2Data($stepData)
    {
        // ✅ SIMPAN TEMP PATHS SAJA (SOLUSI CLEAN PIPELINE)
        $this->listingData = array_merge($this->listingData, $stepData);

        \Log::info('Step 2 data saved (clean pipeline)', [
            'photos_count' => count($stepData['photos'] ?? []),
            'thumbnail_index' => $stepData['thumbnail_index'] ?? null,
        ]);
    }

    public function saveStep3Data($stepData)
    {
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
