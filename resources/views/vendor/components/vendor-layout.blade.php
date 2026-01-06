@props(['title' => 'Vendor Area'])

<x-vendor title="{{ $title }}">
    <div class="py-6">
        {{ $slot }}
    </div>
</x-vendor>