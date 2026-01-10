<div class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Create Listing - Step {{ $currentStep }}</h1>
        
        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 mb-2">
                @for($i = 1; $i <= 4; $i++)
                    <div class="flex-1 h-2 rounded-full {{ $i <= $currentStep ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                @endfor
            </div>
            <div class="text-sm text-gray-600">Step {{ $currentStep }} of 4</div>
        </div>
        
        <!-- Step Content -->
        @if($currentStep == 1)
            <livewire:vendor.steps.step1-business-info 
                :listingData="$listingData"
                :step="$currentStep"
                :key="'step1-' . $currentStep"
            />
        @elseif($currentStep == 2)
            <livewire:vendor.steps.step2-photo-upload 
                :listingData="$listingData"
                :step="$currentStep"
                :key="'step2-' . $currentStep"
            />
        @elseif($currentStep == 3)
            <livewire:vendor.steps.step3-package-pricing 
                :listingData="$listingData"
                :step="$currentStep"
                :key="'step3-' . $currentStep"
            />
        @elseif($currentStep == 4)
            <livewire:vendor.steps.step4-review-submit 
                :listingData="$listingData"
                :step="$currentStep"
                :key="'step4-' . $currentStep"
            />
        @endif
        
        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            @if($currentStep > 1)
                <button wire:click="$dispatch('goPreviousStep')" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    ← Previous
                </button>
            @else
                <div></div> <!-- Spacer -->
            @endif
            
            @if($currentStep < 4)
                <button onclick="validateStep({{ $currentStep }})" 
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Next →
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function validateStep(step) {
    // Dispatch event ke child component untuk validate
    Livewire.dispatch('validate-step-' + step);
    
    // Listen untuk response validation
    Livewire.on('step-validated', (validatedStep) => {
        if (validatedStep === step) {
            // Jika validasi sukses, lanjut step
            Livewire.dispatch('goNextStep');
        }
    });
}
</script>