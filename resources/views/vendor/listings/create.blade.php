@extends('layouts.vendor')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('vendor.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 mx-2 text-xs"></i>
                        <a href="{{ route('vendor.listings.index') }}" class="text-gray-400 hover:text-gray-500">
                            My Listings
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 mx-2 text-xs"></i>
                        <span class="text-gray-900 font-medium">Create New</span>
                    </li>
                </ol>
            </nav>
        </div>
        
        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Buat Listing Baru</h1>
            <p class="text-gray-600 mt-2">Isi form berikut untuk menambahkan layanan Anda</p>
        </div>
        
        <!-- Livewire Component -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <livewire:vendor.listings.create-listing-wizard />
        </div>
    </div>
</div>
@endsection