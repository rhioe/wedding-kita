{{-- resources\views\components\card.blade.php --}}

@props([
    'variant' => 'default', // 'default', 'outline', 'flat', 'hover'
    'padding' => 'default', // 'none', 'tight', 'default', 'loose'
    'class' => '',
])

@php
    // Variant classes
    $variantClasses = [
        'default' => 'bg-white border border-gray-200 shadow-sm',
        'outline' => 'bg-transparent border border-gray-200',
        'flat' => 'bg-gray-50 border-none',
        'hover' => 'bg-white border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300',
    ][$variant] ?? 'bg-white border border-gray-200 shadow-sm';

    // Padding classes
    $paddingClasses = [
        'none' => 'p-0',
        'tight' => 'p-3 sm:p-4',
        'default' => 'p-4 sm:p-5 md:p-6',
        'loose' => 'p-6 sm:p-8 md:p-10',
    ][$padding] ?? 'p-4 sm:p-5 md:p-6';

    // Transition
    $transitionClass = 'transition-all duration-200 ease-out';
@endphp

<div {{ $attributes->merge(['class' => "rounded-xl {$variantClasses} {$paddingClasses} {$transitionClass} {$class}"]) }}>
    {{ $slot }}
</div>