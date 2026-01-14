<?php
// resources/views/livewire/search/search-bar.blade.php
?>

<div class="w-full">
    <div class="relative">
        <input 
            type="text" 
            wire:model.live.debounce.500ms="q"
            placeholder="Cari vendor, lokasi, atau kategori..." 
            class="w-full border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500"
            x-data
            x-on:input="$wire.$set('q', $event.target.value)"
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

    <style>
/* Force consistency for form elements */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Consistent focus rings */
input:focus, select:focus, button:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    ring-width: 2px;
}

/* Consistent border rendering */
.border {
    border-width: 1px;
    border-style: solid;
}
</style>
</div>