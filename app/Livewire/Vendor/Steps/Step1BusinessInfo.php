<?php

// app\Livewire\Vendor\Steps\Step1BusinessInfo.php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;

class Step1BusinessInfo extends Component
{
    // ==================== PROPS FROM PARENT ====================
    public $listingData;

    public $step;

    // ==================== LOCAL STATE ====================
    public $business_name = '';

    public $category_id = '';

    public $location = '';

    public $description = '';

    public $year_established = '';

    public $instagram = '';

    public $website = '';

    // ==================== EVENT LISTENERS ====================
    protected $listeners = [
        'validate-step-1' => 'validateStep',
        'reset-step' => 'resetData',
    ];

    // ==================== LIFECYCLE HOOKS ====================
    public function mount($listingData, $step)
    {
        \Log::info('Step1BusinessInfo MOUNT called', [
            'step' => $step,
            'has_listingData' => ! empty($listingData),
        ]);

        $this->listingData = $listingData;
        $this->step = $step;

        // Load data dari parent
        $this->business_name = $listingData['business_name'] ?? '';
        $this->category_id = $listingData['category_id'] ?? '';
        $this->location = $listingData['location'] ?? '';
        $this->description = $listingData['description'] ?? '';
        $this->year_established = $listingData['year_established'] ?? '';
        $this->instagram = $listingData['instagram'] ?? '';
        $this->website = $listingData['website'] ?? '';
    }

    // ==================== DATA SYNC ====================
    public function updated($propertyName)
    {
        // Auto-save setiap perubahan ke parent
        $this->syncToParent();
    }

    public function syncToParent()
    {
        $stepData = [
            'business_name' => $this->business_name,
            'category_id' => $this->category_id,
            'location' => $this->location,
            'description' => $this->description,
            'year_established' => $this->year_established,
            'instagram' => $this->instagram,
            'website' => $this->website,
        ];

        // Emit ke parent
        $this->dispatch('step1-updated', $stepData);
    }

    // ==================== VALIDATION ====================
    public function validateStep()
    {
        $this->validate([
            'business_name' => 'required|min:3|max:100',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|min:3|max:100',
            'description' => 'required|string|min:50|max:2000',
            'year_established' => 'nullable|integer|min:1900|max:'.date('Y'),
            'instagram' => 'nullable|string|max:30',
            'website' => 'nullable|url|max:255',
        ], [
            'business_name.required' => 'Nama bisnis wajib diisi',
            'category_id.required' => 'Pilih kategori bisnis',
            'location.required' => 'Lokasi wajib diisi',
            'description.required' => 'Deskripsi bisnis wajib diisi',
            'description.min' => 'Deskripsi minimal 50 karakter',
        ]);

        // Jika validasi sukses, sync ke parent dan lanjut step
        $this->syncToParent();
        $this->dispatch('step-validated', 1);

        return true;
    }

    // ==================== RESET ====================
    public function resetData()
    {
        $this->resetExcept(['listingData', 'step']);
        $this->loadDataFromParent();
    }

    // ==================== RENDER ====================
    public function render()
    {
        // Load categories
        $categories = \App\Models\Category::all();

        \Log::info('Step1BusinessInfo RENDER called', [
            'business_name' => $this->business_name,
            'step' => $this->step,
            'categories_count' => $categories->count(),
        ]);

        return view('livewire.vendor.steps.step1-business-info', [
            'categories' => $categories,
        ]);
    }
}
