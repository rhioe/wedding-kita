@extends('layouts.app')

@section('title', 'Studio Foto Elegant - WeddingKita')

@section('content')
<div class="py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-600">
        <a href="/" class="hover:text-pink-600">Home</a> / 
        <a href="/listings" class="hover:text-pink-600">Vendors</a> / 
        <a href="/listings?category=photography" class="hover:text-pink-600">Photography</a> / 
        <span class="text-gray-900 font-medium">Studio Foto Elegant</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2">
            <!-- Gallery -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
                <div class="h-96 bg-gradient-to-br from-blue-100 to-cyan-100 relative">
                    <!-- Main Image -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-camera text-white text-6xl opacity-20"></i>
                    </div>
                    
                    <!-- Navigation -->
                    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Thumbnails -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                        @for($i = 0; $i < 5; $i++)
                        <div class="w-16 h-12 bg-white rounded border {{ $i === 0 ? 'border-pink-500' : 'border-gray-300' }}"></div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Studio Foto Elegant</h1>
                
                <div class="flex items-center gap-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600">4.5 (128 reviews)</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Jakarta, Bandung, Bali</span>
                    </div>
                </div>

                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-bold mb-3">About This Vendor</h3>
                    <p class="text-gray-700 mb-4">
                        Specializing in wedding photography for over 10 years, we capture the most precious moments of your special day. Our team of professional photographers ensures every smile, tear, and laugh is beautifully preserved.
                    </p>
                    <p class="text-gray-700">
                        We offer various packages from pre-wedding to full-day coverage, with options for digital albums, prints, and custom photo books.
                    </p>
                </div>

                <!-- Services -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4">Services Offered</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Pre-Wedding', 'Full Day Coverage', 'Drone Photography', 'Photo Album', 'Digital Files', 'Printing'] as $service)
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm">
                            {{ $service }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews Preview -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">Reviews</h3>
                        <a href="#" class="text-pink-600 hover:text-pink-700 font-medium">View all reviews →</a>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
                                    <div>
                                        <p class="font-medium">Sarah & John</p>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span>2 weeks ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700">"Amazing photographer! Captured every moment beautifully."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Booking) -->
        <div class="lg:col-span-1">
            <!-- Pricing Card -->
            <div class="bg-white rounded-xl shadow-sm border p-6 sticky top-24">
                <div class="text-center mb-6">
                    <div class="text-4xl font-bold text-gray-900 mb-2">Rp 8,500,000</div>
                    <p class="text-gray-600">Starting price</p>
                </div>

                <!-- Packages -->
                <div class="space-y-4 mb-6">
                    <div class="border rounded-lg p-4 hover:border-pink-500 cursor-pointer">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold">Basic Package</h4>
                            <span class="font-bold text-pink-600">Rp 8,5jt</span>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                6 Hours Coverage
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                300+ Edited Photos
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Online Gallery
                            </li>
                        </ul>
                    </div>

                    <div class="border-2 border-pink-500 rounded-lg p-4 bg-pink-50">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold">Premium Package</h4>
                            <span class="font-bold text-pink-600">Rp 12,5jt</span>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Full Day Coverage
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                500+ Edited Photos
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Photo Album
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Drone Shots
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Button -->
                @auth
                    <button class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white py-3.5 rounded-lg font-bold hover:opacity-90 mb-4">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Contact via WhatsApp
                    </button>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Please login to contact this vendor
                        </p>
                    </div>
                    <a href="{{ route('login') }}" 
                       class="block w-full bg-pink-600 text-white py-3.5 rounded-lg font-bold text-center hover:bg-pink-700 mb-3">
                        Login to Contact
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full border border-gray-300 text-gray-700 py-3.5 rounded-lg font-medium text-center hover:bg-gray-50">
                        Create Account
                    </a>
                @endauth

                <!-- Quick Info -->
                <div class="space-y-3 mt-6 pt-6 border-t">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock w-5 mr-3"></i>
                        <span>Response time: Within 1 hour</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar-check w-5 mr-3"></i>
                        <span>100+ weddings covered</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-award w-5 mr-3"></i>
                        <span>Verified vendor</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection