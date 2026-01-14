{{-- resources\views\home.blade.php --}}

@extends('layouts.master')

@section('title', 'WeddingKita - Marketplace Vendor Pernikahan')

@section('content')
<div class="min-h-[60vh] flex items-center">
    <div class="max-w-7xl mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Temukan Vendor Pernikahan Terbaik
        </h1>
        <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
            Ribuan fotografer, venue, makeup artist, dan vendor pernikahan siap membuat hari istimewa Anda sempurna.
        </p>
        
        <!-- Search Bar -->
        <div class="max-w-md mx-auto mb-12">
            @livewire('search.search-bar')
        </div>
        
        <!-- Quick Categories -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12">
            @foreach(['Fotografer', 'Venue', 'Catering', 'Makeup', 'Dekorasi', 'WO'] as $category)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-default cursor-pointer">
                <div class="text-3xl mb-2">📷</div>
                <div class="font-medium text-gray-700">{{ $category }}</div>
            </div>
            @endforeach
        </div>
        
        <!-- Featured Listings -->
        @livewire('search.search-listings', ['showOnlyFeatured' => true])
    </div>
</div>
@endsection