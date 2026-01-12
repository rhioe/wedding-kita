{{-- resources/views/admin/listings/review.blade.php --}}

@extends('admin.admin')

@section('title', 'Review Listing - Admin WeddingKita')

@section('content')
<div class="py-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Review Listing</h1>
                <p class="text-gray-600 mt-2">Review all details before making a decision</p>
            </div>
            
            <!-- Status Badge -->
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="text-2xl font-bold text-yellow-700">Pending Review</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Breadcrumb & Back Button -->
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-pink-600">Dashboard</a>
                <i class="fas fa-chevron-right mx-2"></i>
                <a href="{{ route('admin.listings.pending') }}" class="hover:text-pink-600">Pending Listings</a>
                <i class="fas fa-chevron-right mx-2"></i>
                <span class="text-gray-900 font-medium">Review: {{ $listing->title }}</span>
            </div>
            
            <a href="{{ route('admin.listings.pending') }}" 
               class="flex items-center gap-2 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Review Sections (Mirip Step 4 Create Listing) -->
    <div class="space-y-6">
        <!-- Section 1: Informasi Bisnis -->
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">1. Business Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Business Name</p>
                    <p class="font-medium text-gray-900">{{ $listing->business_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="font-medium text-gray-900">{{ $listing->category->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Location</p>
                    <p class="font-medium text-gray-900">{{ $listing->location }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Year Established</p>
                    <p class="font-medium text-gray-900">{{ $listing->year_established ?: 'N/A' }}</p>
                </div>
            </div>
            
            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-2">Business Description</p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $listing->description }}</p>
                </div>
            </div>
            
            @if($listing->instagram)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Instagram</p>
                <p class="font-medium text-gray-900">{{ $listing->instagram }}</p>
            </div>
            @endif
            
            @if($listing->website)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Website</p>
                <p class="font-medium text-gray-900">{{ $listing->website }}</p>
            </div>
            @endif
        </div>
        
        <!-- Section 2: Foto Portfolio -->
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">2. Portfolio Photos</h3>
            
            @if($listing->photos->count() > 0)
            <div class="mb-4">
                <p class="text-sm text-gray-500">
                    Total Photos: {{ $listing->photos->count() }} 
                    | Thumbnail: 
                    <span class="text-green-600 font-medium">
                        @foreach($listing->photos as $photo)
                            @if($photo->is_thumbnail)
                                Photo #{{ $loop->iteration }}
                            @endif
                        @endforeach
                    </span>
                </p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($listing->photos as $photo)
                <div class="relative">
                    <div class="aspect-square rounded-lg overflow-hidden border {{ $photo->is_thumbnail ? 'border-blue-500 border-2' : 'border-gray-200' }}">
                        {{-- FIXED VERSION --}}
                        @php
                            // Generate correct URL
                            $photoUrl = asset('storage/' . $photo->path);
                            // Verify file exists
                            $fileExists = Storage::disk('public')->exists($photo->path);
                        @endphp
                        
                        @if($fileExists)
                            <img src="{{ $photoUrl }}" 
                                alt="Photo {{ $loop->iteration }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/400/FF6B6B/FFFFFF?text=Error+Loading+Photo';">
                        @else
                            {{-- Fallback if file missing --}}
                            <div class="w-full h-full bg-gradient-to-r from-gray-100 to-gray-200 flex flex-col items-center justify-center p-4">
                                <i class="fas fa-image text-gray-300 text-2xl mb-2"></i>
                                <p class="text-gray-500 text-sm">Photo not found</p>
                                <p class="text-xs text-gray-400 mt-1 truncate w-full px-2">{{ basename($photo->path) }}</p>
                            </div>
                        @endif
                    </div>
                    
                    @if($photo->is_thumbnail)
                    <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        <i class="fas fa-star"></i>
                        <span>Thumbnail</span>
                    </div>
                    @endif
                    
                    {{-- Photo info badge --}}
                    <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full">
                        {{ $loop->iteration }}/{{ $listing->photos->count() }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-images text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">No photos uploaded</p>
            </div>
            @endif
            
            {{-- Debug info (temporary) --}}
            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-xs text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i>
                    Photo Paths: 
                    @foreach($listing->photos as $photo)
                        <span class="block mt-1 font-mono text-xs">{{ $photo->path }}</span>
                    @endforeach
                </p>
            </div>
        </div>
        
        <!-- Section 3: Detail Paket & Harga -->
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">3. Package & Pricing Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Package Name</p>
                    <p class="font-medium text-gray-900">{{ $listing->title }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Price</p>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($listing->price, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            
            @if($listing->package_description)
            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-2">Package Description</p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $listing->package_description }}</p>
                </div>
            </div>
            @endif
            
            @if($listing->validity_period)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Validity Period</p>
                <p class="font-medium text-gray-900">{{ $listing->validity_period }}</p>
            </div>
            @endif
        </div>
        
        <!-- Section 4: Vendor Information -->
        <div class="bg-white rounded-xl p-6 shadow-sm border">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">4. Vendor Information</h3>
            
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xl">
                        {{ strtoupper(substr($listing->vendor->business_name ?? 'V', 0, 1)) }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $listing->vendor->business_name ?? 'Unknown Vendor' }}</p>
                    <p class="text-sm text-gray-500">{{ $listing->vendor->user->email ?? 'No email' }}</p>
                    <p class="text-sm text-gray-500">
                        Joined: {{ $listing->vendor->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            
            @if($listing->vendor->description)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Vendor Description</p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $listing->vendor->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Decision Section -->
    <div class="mt-8 bg-white rounded-xl p-6 shadow-sm border">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Make Decision</h3>
        
        <!-- Warning Alert -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                <div>
                    <p class="text-sm text-yellow-800">
                        <span class="font-semibold">Important:</span> 
                        Please review all information carefully before making a decision. 
                        Once approved, the listing will be visible to the public.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-500">
                <p>Listing ID: <span class="font-medium">{{ $listing->id }}</span></p>
                <p>Submitted: <span class="font-medium">{{ $listing->created_at->format('d M Y, H:i') }}</span></p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Reject Form -->
                <form method="POST" action="{{ route('admin.listings.reject', $listing->id) }}" 
                      class="flex items-center space-x-3" id="rejectForm">
                    @csrf
                    <div class="relative" x-data="{ showReason: false }">
                        <!-- Reject Button -->
                        <button type="button" 
                                @click="showReason = !showReason"
                                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                            <i class="fas fa-times-circle mr-2"></i>
                            Reject Listing
                        </button>
                        
                        <!-- Reason Input (hidden by default) -->
                        <div x-show="showReason" 
                             @click.away="showReason = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg p-4 border z-10">
                            <p class="text-sm font-medium text-gray-900 mb-2">Reason for rejection (optional)</p>
                            <textarea name="reason" 
                                      rows="3"
                                      class="w-full border border-gray-300 rounded-lg p-3 text-sm"
                                      placeholder="Provide feedback to the vendor..."></textarea>
                            <div class="flex items-center justify-end space-x-3 mt-3">
                                <button type="button" 
                                        @click="showReason = false"
                                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                                    Confirm Reject
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Approve Form -->
                <form method="POST" action="{{ route('admin.listings.approve', $listing->id) }}">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to approve this listing? It will become publicly visible.')"
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                        <i class="fas fa-check-circle mr-2"></i>
                        Approve Listing
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection