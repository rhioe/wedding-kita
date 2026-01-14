{{-- resources\views\components\empty-state.blade.php --}}

@props([
    'icon' => '🔍',
    'title' => 'Tidak ada data ditemukan',
    'description' => null,
    'action' => null,
    'actionText' => 'Coba lagi',
])

<div class="text-center py-12">
    <div class="text-5xl mb-4">{{ $icon }}</div>
    
    <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $title }}</h3>
    
    @if($description)
        <p class="text-gray-600 mb-6 max-w-md mx-auto">{{ $description }}</p>
    @endif
    
    @if($action)
        <button onclick="{{ $action }}" class="inline-flex items-center text-rose-600 hover:text-rose-700 font-medium">
            {{ $actionText }}
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    @endif
</div>