<?php

namespace App\Livewire\Vendor;

use Livewire\Component;

class CreateListing extends Component
{
    public $currentStep = 1;
    
    public function render()
    {
        return view('livewire.vendor.create-listing');
    }
}