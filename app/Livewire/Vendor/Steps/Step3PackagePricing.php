<?php
//app\Livewire\Vendor\Steps\Step3PackagePricing.php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;

class Step3PackagePricing extends Component
{
    public $listingData;
    public $step;

    public $package_name = '';
    public $price = '';
    public $package_description = '';
    public $validity_period = '';

    protected $rules = [
        'package_name' => 'required|min:3|max:100',
        'price' => 'required|numeric|min:1000',
        'package_description' => 'nullable|max:1000',
        'validity_period' => 'nullable|max:50',
    ];

    protected $listeners = [
        'load-step3-data' => 'loadData',
        'validate-step-3' => 'validateStep',
    ];

    protected $validationAttributes = [
        'package_name' => 'Nama Paket',
        'price' => 'Harga',
        'package_description' => 'Deskripsi Paket',
        'validity_period' => 'Masa Berlaku',
    ];

    protected $messages = [
        'package_name.required' => 'Nama paket wajib diisi.',
        'package_name.min' => 'Nama paket minimal 3 karakter.',
        'price.required' => 'Harga wajib diisi.',
        'price.numeric' => 'Harga harus berupa angka.',
        'price.min' => 'Harga minimal Rp1.000.',
    ];

    public function validateStep()
    {
        // bersihkan format rupiah
        $this->price = preg_replace('/\D/', '', $this->price);

        $this->validate();

        $this->dispatch('step3-updated', [
            'package_name' => $this->package_name,
            'price' => $this->price,
            'package_description' => $this->package_description,
            'validity_period' => $this->validity_period,
        ]);

        $this->dispatch('step-validated', 3);
    }




    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        $this->loadData($listingData);
    }

    public function loadData($data)
    {
        $this->package_name = $data['package_name'] ?? '';
        $this->price = $data['price'] ?? '';
        $this->package_description = $data['package_description'] ?? '';
        $this->validity_period = $data['validity_period'] ?? '';
    }

    

    public function render()
    {
        return view('livewire.vendor.steps.step3-package-pricing');
    }
}
