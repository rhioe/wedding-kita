{{-- resources\views\components\grid-container.blade.php --}}

@props([
    'gap' => 'default', // 'none', 'tight', 'default', 'loose'
    'columns' => 'responsive', // '1', '2', '3', '4', '5', 'responsive'
    'class' => '',
])

@php
    // Gap classes
    $gapClasses = [
        'none' => 'gap-0',
        'tight' => 'gap-2 sm:gap-3 md:gap-4',
        'default' => 'gap-4 sm:gap-5 md:gap-6',
        'loose' => 'gap-6 sm:gap-8 md:gap-10',
    ][$gap] ?? 'gap-4 sm:gap-5 md:gap-6';

    // Columns classes
    $columnClasses = [
        '1' => 'grid-cols-1',
        '2' => 'grid-cols-1 xs:grid-cols-2',
        '3' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        '4' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4',
        '5' => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 3xl:grid-cols-5',
        'responsive' => 'grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5',
    ][$columns] ?? 'grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5';
@endphp

<div {{ $attributes->merge(['class' => "grid {$columnClasses} {$gapClasses} {$class}"]) }}>
    {{ $slot }}
</div>