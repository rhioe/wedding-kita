@props(['type' => 'button', 'variant' => 'primary'])

@php
    $classes = match($variant) {
        'primary' => 'bg-pink-600 text-white hover:bg-pink-700',
        'secondary' => 'border border-gray-300 text-gray-700 hover:bg-gray-50',
        'outline' => 'border border-pink-600 text-pink-600 hover:bg-pink-50',
        default => 'bg-pink-600 text-white hover:bg-pink-700',
    };
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "px-4 py-2 rounded-lg font-medium transition-colors $classes"]) }}
>
    {{ $slot }}
</button>