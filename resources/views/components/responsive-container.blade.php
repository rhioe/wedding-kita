{{-- resources\views\components\responsive-container.blade.php --}}
@props([
    'size' => 'default', // 'tight', 'default', 'wide', 'full'
    'padding' => 'default', // 'none', 'tight', 'default', 'loose'
    'class' => '',
])

@php
    // Size classes
    $sizeClasses = [
        'tight' => 'max-w-4xl mx-auto',
        'default' => 'max-w-7xl mx-auto',
        'wide' => 'max-w-[1920px] mx-auto',
        'full' => 'w-full',
    ][$size] ?? 'max-w-7xl mx-auto';

    // Padding classes
    $paddingClasses = [
        'none' => 'px-0',
        'tight' => 'px-3 sm:px-4',
        'default' => 'px-4 sm:px-6 lg:px-8',
        'loose' => 'px-6 sm:px-8 lg:px-12',
    ][$padding] ?? 'px-4 sm:px-6 lg:px-8';
@endphp

<div {{ $attributes->merge(['class' => "{$sizeClasses} {$paddingClasses} {$class}"]) }}>
    {{ $slot }}
</div>