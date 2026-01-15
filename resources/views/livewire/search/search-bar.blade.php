{{-- resources/views/livewire/search/search-bar.blade.php --}}
<div class="w-full">
    <div class="relative">
        <input 
            type="text" 
            wire:model.debounce.500ms="q"
            placeholder="Cari vendor, lokasi, atau kategori..." 
            class="w-full border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-primary"
        >
        <div class="absolute right-3 top-3 text-gray-400">
            @if($q)
                <button type="button" wire:click="$set('q', '')" class="mr-2 hover:text-gray-600">
                    ✕
                </button>
            @endif
            🔍
        </div>
    </div>
    
    <!-- Debug info (temporary) -->
    <div class="text-xs text-gray-500 mt-1" wire:loading wire:target="q">
        Searching...
    </div>

    {{-- HAPUS SELURUH BAGIAN <style> DI BAWAH INI --}}
</div>