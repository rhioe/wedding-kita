{{-- resources\views\components\skeleton.blade.php --}}

@props([
    'type' => 'text', // 'text', 'image', 'card', 'button'
    'lines' => 1,
    'class' => '',
])

@php
    $baseClass = 'animate-pulse bg-gray-200 rounded';
    
    $typeClasses = [
        'text' => 'h-4',
        'image' => 'h-48 w-full',
        'card' => 'h-64 w-full',
        'button' => 'h-10 w-24',
    ][$type] ?? 'h-4';
@endphp

@if($type === 'text' && $lines > 1)
    <div class="space-y-2 {{ $class }}">
        @for($i = 0; $i < $lines; $i++)
            <div class="{{ $baseClass }} {{ $typeClasses }} {{ $i === $lines - 1 ? 'w-3/4' : 'w-full' }}"></div>
        @endfor
    </div>
@else
    <div class="{{ $baseClass }} {{ $typeClasses }} {{ $class }}"></div>
@endif