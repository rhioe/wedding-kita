<div> <!-- ROOT ELEMENT -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Step 3: Package & Pricing</h2>
        <p class="text-gray-600 mb-6">Set your package details and pricing</p>
        
        <div class="space-y-4">
            <!-- Package Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Package Name *
                </label>
                <input type="text" wire:model="package_name" 
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <!-- Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Price (IDR) *
                </label>
                <input type="number" wire:model="price" 
                       class="w-full px-4 py-2 border rounded-lg"
                       placeholder="5000000">
            </div>
            
            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Package Description (Optional)
                </label>
                <textarea wire:model="package_description" 
                          rows="3"
                          class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
            
            <!-- Validity Period -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Validity Period (Optional)
                </label>
                <input type="text" wire:model="validity_period" 
                       class="w-full px-4 py-2 border rounded-lg"
                       placeholder="e.g., 6 months, 1 year">
            </div>
        </div>
    </div>
</div>