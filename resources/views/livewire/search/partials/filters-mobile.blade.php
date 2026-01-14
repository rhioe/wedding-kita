{{-- resources\views\livewire\search\partials\filters-mobile.blade.php --}}

{{-- Mobile Filters --}}
<div class="space-y-5">
    <!-- Category -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
        <select wire:model="filters.category_id" 
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Location -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
        <select wire:model="filters.location" 
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
            <option value="">Semua Lokasi</option>
            @foreach($locations as $location)
                <option value="{{ $location }}">{{ $location }}</option>
            @endforeach
        </select>
    </div>

    <!-- Price Range -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
        <div class="grid grid-cols-2 gap-2">
            <div class="relative">
                <input 
                    type="number" 
                    wire:model="filters.min_price"
                    placeholder="Min" 
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm pr-8 focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
                <span class="absolute right-3 top-2.5 text-gray-400 text-xs">Rp</span>
            </div>
            <div class="relative">
                <input 
                    type="number" 
                    wire:model="filters.max_price"
                    placeholder="Max" 
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm pr-8 focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
                <span class="absolute right-3 top-2.5 text-gray-400 text-xs">Rp</span>
            </div>
        </div>
    </div>

    <!-- Featured -->
    <div>
        <label class="flex items-center">
            <input 
                type="checkbox" 
                wire:model="filters.featured" 
                class="rounded border-gray-200 text-rose-600 focus:ring-rose-500 mr-3 h-4 w-4"
            >
            <span class="text-sm text-gray-700">Hanya Vendor Unggulan</span>
        </label>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 pt-5 border-t">
        <button 
            wire:click="clearFilters"
            class="flex-1 border border-gray-200 text-gray-700 py-2.5 rounded-lg font-medium text-sm"
        >
            Reset
        </button>
        <button 
            wire:click="applyFilters"
            class="flex-1 bg-rose-600 text-white py-2.5 rounded-lg font-medium text-sm"
        >
            Terapkan
        </button>
    </div>
</div>