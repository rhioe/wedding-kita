<div style="border: 5px solid purple; padding: 30px; background: yellow;">
    <h1>🎉 CHILD COMPONENT BERHASIL LOAD!</h1>
    <p>Step: {{ $step }}</p>
    <p>Business Name from Parent: {{ $listingData['business_name'] ?? 'Empty' }}</p>
    
    <h3>Test Livewire Binding</h3>
    <input type="text" wire:model="business_name" placeholder="Type here...">
    <p>Current Value: <strong>{{ $business_name }}</strong></p>
    
    <button wire:click="$set('business_name', 'TEST SUCCESS')">
        Click to Test Livewire
    </button>
    
    <button wire:click="$dispatch('validate-step-1')" style="background: blue; color: white;">
        Test Validate Event
    </button>
</div>