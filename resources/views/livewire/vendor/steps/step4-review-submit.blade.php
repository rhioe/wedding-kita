<div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Step 4: Review & Submit</h2>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="space-y-6">
            <!-- Business Info -->
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-store text-purple-600 mr-2"></i>
                    Business Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Business Name:</p>
                        <p class="font-medium">{{ $listingData['business_name'] ?: 'Not set' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Category:</p>
                        <p class="font-medium">
                            @php
                                $category = \App\Models\Category::find($listingData['category_id']);
                                echo $category ? $category->name : 'Not set';
                            @endphp
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Location:</p>
                        <p class="font-medium">{{ $listingData['location'] ?: 'Not set' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Year Established:</p>
                        <p class="font-medium">{{ $listingData['year_established'] ?: 'Not set' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Photos Info -->
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-images text-blue-600 mr-2"></i>
                    Photos ({{ count($listingData['photos'] ?? []) }})
                </h3>
                
                @if(!empty($listingData['photos']) && is_array($listingData['photos']))
                    <div class="grid grid-cols-3 gap-3 mt-3">
                        @foreach($listingData['photos'] as $index => $photo)
                            <div class="relative border rounded overflow-hidden">
                                <!-- Cek jika photo adalah Livewire file object -->
                                @if(is_object($photo) && method_exists($photo, 'temporaryUrl'))
                                    <img src="{{ $photo->temporaryUrl() }}" 
                                        class="w-full h-24 object-cover">
                                @else
                                    <!-- Fallback: tampilkan placeholder -->
                                    <div class="w-full h-24 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                
                                @if($index == ($listingData['thumbnail_index'] ?? 0))
                                    <div class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                        Thumbnail
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No photos uploaded</p>
                @endif
            </div>
            
            <!-- Package Info -->
            <div class="border rounded-lg p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-gift text-purple-600 mr-2"></i>
                    Package & Pricing
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Package Name:</p>
                        <p class="font-medium">{{ $listingData['package_name'] ?: 'Not set' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Price:</p>
                        <p class="font-medium">
                            {{ $listingData['price'] ? 'Rp ' . number_format($listingData['price'], 0, ',', '.') : 'Not set' }}
                        </p>
                    </div>
                    @if($listingData['validity_period'])
                    <div>
                        <p class="text-gray-600 text-sm">Validity Period:</p>
                        <p class="font-medium">{{ $listingData['validity_period'] }}</p>
                    </div>
                    @endif
                </div>
                @if($listingData['package_description'])
                <div class="mt-3">
                    <p class="text-gray-600 text-sm">Package Description:</p>
                    <p class="font-medium">{{ $listingData['package_description'] }}</p>
                </div>
                @endif
            </div>
            
            <!-- Submit Button -->
            <div class="pt-4 border-t">
                <button wire:click="submitListing"
                        wire:loading.attr="disabled"
                        wire:target="submitListing"
                        class="w-full bg-green-500 hover:bg-green-600 disabled:bg-green-300 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center">
                    <span wire:loading.remove wire:target="submitListing">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Listing for Review
                    </span>
                    <span wire:loading wire:target="submitListing">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Processing...
                    </span>
                </button>
                <p class="text-sm text-gray-500 mt-2 text-center">
                    Your listing will be reviewed by admin before going live
                </p>
            </div>
        </div>
    </div>
</div>