{{-- resources\views\listings\index.blade.php --}}

@extends('layouts.app')

@section('title', 'Browse Vendors - WeddingKita')

@section('content')
<div class="py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Find Wedding Vendors</h1>
        <p class="text-gray-600">Browse thousands of verified wedding professionals</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border p-6 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-6">Filters</h3>
                
                <!-- Category -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Category</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-pink-600">
                            <span class="ml-2 text-sm">Photography</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-pink-600">
                            <span class="ml-2 text-sm">Venues</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-pink-600">
                            <span class="ml-2 text-sm">Catering</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded text-pink-600">
                            <span class="ml-2 text-sm">Decoration</span>
                        </label>
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Location</h4>
                    <input type="text" 
                           placeholder="City or region"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Price Range</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="price" class="text-pink-600">
                            <span class="ml-2 text-sm">Under Rp 5M</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="price" class="text-pink-600">
                            <span class="ml-2 text-sm">Rp 5M - 10M</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="price" class="text-pink-600">
                            <span class="ml-2 text-sm">Over Rp 10M</span>
                        </label>
                    </div>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Minimum Rating</h4>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-gray-300"></i>
                        <span class="ml-2 text-sm">4.0 & up</span>
                    </div>
                </div>

                <button class="w-full bg-pink-600 text-white py-2.5 rounded-lg font-medium hover:bg-pink-700">
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="lg:col-span-3">
            <!-- Search Bar -->
            <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               placeholder="Search vendors, services, or keywords..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <button class="bg-pink-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-pink-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Results Header -->
            <div class="flex items-center justify-between mb-6">
                <p class="text-gray-600">Showing <span class="font-medium">0</span> vendors</p>
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option>Sort by: Recommended</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Rating: High to Low</option>
                </select>
            </div>

            <!-- Listings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sample Listing Card -->
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition-all">
                    <!-- Image -->
                    <div class="h-48 bg-gradient-to-br from-blue-100 to-cyan-100 relative">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium">
                            Photography
                        </div>
                        <button class="absolute top-4 right-4 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white">
                            <i class="far fa-heart text-gray-600"></i>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-bold text-gray-900 text-lg">Studio Foto Elegant</h3>
                            <span class="text-lg font-bold text-pink-600">Rp 8,5jt</span>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-sm text-gray-600 ml-2">4.5 (128 reviews)</span>
                        </div>
                        
                        <div class="flex items-center text-gray-600 text-sm mb-6">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Jakarta, Bandung, Bali</span>
                        </div>
                        
                        <a href="/listings/1" 
                           class="block w-full bg-pink-600 text-white text-center py-3 rounded-lg font-medium hover:bg-pink-700">
                            View Details
                        </a>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Load More -->
            <div class="text-center mt-10">
                <button class="px-6 py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                    Load More Vendors
                </button>
            </div>
        </div>
    </div>
</div>
@endsection