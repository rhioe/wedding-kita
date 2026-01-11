{{-- resources/views/admin/listings/pending.blade.php --}}

@extends('admin.admin')

@section('title', 'Pending Listings - Admin WeddingKita')

@section('content')
<div class="py-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pending Listings</h1>
                <p class="text-gray-600 mt-2">Review vendor submissions before approval</p>
            </div>
            
            <!-- Stats Badge -->
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Waiting for review</p>
                        <p class="text-2xl font-bold text-yellow-700">
                            {{ $listings->total() }} listing(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mt-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-pink-600">Dashboard</a>
            <i class="fas fa-chevron-right mx-2"></i>
            <span class="text-gray-900 font-medium">Pending Listings</span>
        </div>
    </div>

    <!-- Filters Form -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border p-4">
        <form method="GET" action="{{ route('admin.listings.pending') }}" class="space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search listings, vendors, categories..."
                               class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div>
                    <select name="category" 
                            class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort By -->
                <div>
                    <select name="sort" 
                            class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            class="px-6 py-2.5 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.listings.pending') }}" 
                       class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Listings Table -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        @if($listings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Listing Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vendor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Submitted
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($listings as $listing)
                    <tr class="hover:bg-gray-50">
                        <!-- Listing Details -->
                        <td class="px-6 py-4">
                            <div class="flex items-start space-x-4">
                                <!-- Thumbnail -->
                                <div class="flex-shrink-0">
                                    @php
                                        $thumbnail = $listing->photos->where('is_thumbnail', true)->first();
                                    @endphp
                                    <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-200">
                                        @if($thumbnail && Storage::exists($thumbnail->path))
                                        <img src="{{ Storage::url($thumbnail->path) }}" 
                                             alt="{{ $listing->title }}"
                                             class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full bg-gradient-to-r from-pink-100 to-rose-100 flex items-center justify-center">
                                            <i class="fas fa-image text-pink-300"></i>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $listing->title }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $listing->location }}
                                    </p>
                                    <div class="mt-2 flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                            {{ $listing->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Vendor -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">
                                            {{ strtoupper(substr($listing->vendor->business_name ?? 'V', 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $listing->vendor->business_name ?? 'Unknown Vendor' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $listing->vendor->user->email ?? 'No email' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Price -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($listing->price, 0, ',', '.') }}
                            </p>
                            @if($listing->validity_period)
                            <p class="text-xs text-gray-500">
                                Valid: {{ $listing->validity_period }}
                            </p>
                            @endif
                        </td>
                        
                        <!-- Submitted -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm text-gray-900">
                                {{ $listing->created_at->format('d M Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $listing->created_at->diffForHumans() }}
                            </p>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <!-- Review Button -->
                                <a href="{{ route('admin.listings.review', $listing->id) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-600 to-rose-600 text-white text-sm font-medium rounded-lg hover:opacity-90">
                                    <i class="fas fa-eye"></i>
                                    Review Details
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $listings->links() }}
        </div>
        
        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gradient-to-r from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No pending listings!</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-6">
                All vendor submissions have been reviewed. Great work! 
                New listings will appear here when vendors submit them.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-rose-600 text-white px-6 py-3 rounded-lg font-medium hover:opacity-90">
                    <i class="fas fa-tachometer-alt"></i>
                    Back to Dashboard
                </a>
                <a href="{{ route('admin.listings.pending') }}?sort=oldest" 
                   class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50">
                    <i class="fas fa-redo"></i>
                    Check Again
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection