<!-- resources/views/livewire/vendor/listings/create-listing.blade.php -->
<div class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- SIMPLE HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Buat Listing Vendor</h1>
            <p class="text-gray-600">Step {{ $currentStep }} dari 4</p>
        </div>
        
        <!-- SIMPLE PROGRESS BAR -->
        <div class="mb-8">
            <div class="flex items-center space-x-1">
                @for($i = 1; $i <= 4; $i++)
                <div class="flex-1 h-2 rounded-full {{ $i <= $currentStep ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                @endfor
            </div>
            <div class="text-sm text-gray-500 mt-1">
                @if($currentStep == 1) Informasi Bisnis
                @elseif($currentStep == 2) Foto & Galeri
                @elseif($currentStep == 3) Paket & Harga
                @elseif($currentStep == 4) Review & Submit
                @endif
            </div>
        </div>
        
        <!-- ⚠️ HANYA SATU STEP YANG DITAMPILKAN -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            @if($currentStep == 1)
                <livewire:vendor.steps.step1-business-info 
                    :listingData="$listingData['step1'] ?? null"
                    :step="$currentStep"
                    key="step1"
                />
            @elseif($currentStep == 2)
                <livewire:vendor.steps.step2-photo-upload 
                    :listingData="$listingData['step2'] ?? ['photos' => [], 'thumbnail_id' => null]"
                    :step="$currentStep"
                    key="step2"
                />
            @elseif($currentStep == 3)
                <livewire:vendor.steps.step3-package-pricing 
                    :listingData="$listingData['step3'] ?? null"
                    :step="$currentStep"
                    key="step3"
                />
            @elseif($currentStep == 4)
                <livewire:vendor.steps.step4-review-submit 
                    :listingData="$listingData"
                    :step="$currentStep"
                    key="step4"
                />
            @endif
        </div>
        
        <!-- SIMPLE NAVIGATION -->
        <div class="mt-8 flex justify-between">
            @if($currentStep > 1)
                <button wire:click="previousStep" 
                        class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50">
                    ← Kembali
                </button>
            @else
                <div></div>
            @endif
            
            @if($currentStep < 4)
                <button wire:click="nextStep"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Lanjut →
                </button>
            @else
                <button wire:click="submitListing"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Submit Listing
                </button>
            @endif
        </div>
    </div>
</div>