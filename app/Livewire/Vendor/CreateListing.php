<?php

namespace App\Livewire\Vendor;

use Livewire\Component;

class CreateListing extends Component
{
    public $currentStep = 1;
    public $listingData = [];  // Biarkan array kosong

    protected $listeners = [
        'step1-updated' => 'handleStep1Update',
        'step2-updated' => 'handleStep2Update',
        'step3-updated' => 'handleStep3Update',
        'step4-updated' => 'handleStep4Update',
        'goNextStep' => 'nextStep',
        'goPreviousStep' => 'previousStep',
        'step-validated' => 'handleStepValidated',
    ];

    public function mount()
    {
        // INISIALISASI DI SINI, bukan di property
        $this->listingData = [
            'step1' => null,
            'step2' => [
                'photos' => [],
                'thumbnail_id' => null
            ],
            'step3' => null,
            'step4' => null,
        ];

        // Load dari session jika ada
        if (session()->has('listing.draft')) {
            $draft = session()->get('listing.draft');
            // Merge dengan struktur default
            $this->listingData = array_merge($this->listingData, $draft);
        }
    }

    public function handleStep1Update($data)
    {
        $this->listingData['step1'] = $data;
        $this->saveDraft();
    }

    public function handleStep2Update($data)
    {
        $this->listingData['step2'] = $data;
        $this->saveDraft();
    }

    public function handleStep3Update($data)
    {
        $this->listingData['step3'] = $data;
        $this->saveDraft();
    }

    public function handleStep4Update($data)
    {
        $this->listingData['step4'] = $data;
        $this->saveDraft();
    }

    public function handleStepValidated($step)
    {
        $this->nextStep();
    }

    public function nextStep()
    {
        if ($this->currentStep < 4) {
            $this->currentStep++;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    public function saveDraft()
    {
        session()->put('listing.draft', $this->listingData);
    }

    public function clearDraft()
    {
        session()->forget('listing.draft');
        $this->mount(); // Reset ke default
    }

    public function submitListing()
    {
        // TODO: Save to database
        $this->clearDraft();
        $this->dispatch('listing-submitted');
    }

    public function render()
    {
        // Debug: Pastikan struktur data benar
        // dd($this->listingData);
        
        return view('livewire.vendor.create-listing');
    }
}