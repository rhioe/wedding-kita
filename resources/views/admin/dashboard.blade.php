{{-- resources/views/admin/dashboard.blade.php --}}

@extends('admin.admin')

@section('title', 'Admin Dashboard - WeddingKita')

@section('content')
<div class="py-6">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Welcome back, Administrator! 👋
        </h1>
        <p class="text-gray-600">Manage vendors, listings, and platform operations.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Listings -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Listings</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ \App\Models\Listing::count() }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-list text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View all listings →
                </a>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pending Review</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ \App\Models\Listing::where('status', 'pending')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.listings.pending') }}" 
                   class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                    Review now →
                </a>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Approved</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ \App\Models\Listing::where('status', 'approved')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    View approved →
                </a>
            </div>
        </div>

        <!-- Total Vendors -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Vendors</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ \App\Models\Vendor::count() }}
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-store text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Manage vendors →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Listings -->
        <div class="bg-white rounded-xl shadow-sm border p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Listings</h2>
                <a href="#" class="text-sm text-pink-600 hover:text-pink-800 font-medium">View all</a>
            </div>
            
            <div class="space-y-4">
                @php
                    $recentListings = \App\Models\Listing::with('vendor', 'category')
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp
                
                @forelse($recentListings as $listing)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heart text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $listing->title }}</p>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-sm text-gray-500">{{ $listing->vendor->business_name ?? 'N/A' }}</span>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    @if($listing->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($listing->status == 'approved') bg-green-100 text-green-800
                                    @elseif($listing->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">Rp {{ number_format($listing->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No listings yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions Panel -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            
            <div class="space-y-4">
                <a href="{{ route('admin.listings.pending') }}" 
                   class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg hover:shadow-md transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Review Listings</p>
                            <p class="text-sm text-gray-600">Approve or reject pending submissions</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>

                <a href="#" 
                   class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:shadow-md transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Manage Vendors</p>
                            <p class="text-sm text-gray-600">View and manage vendor accounts</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>

                <a href="#" 
                   class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg hover:shadow-md transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Platform Settings</p>
                            <p class="text-sm text-gray-600">Configure site settings</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </a>
            </div>

            <!-- Pending Count Alert -->
            @php
                $pendingCount = \App\Models\Listing::where('status', 'pending')->count();
            @endphp
            
            @if($pendingCount > 0)
            <div class="mt-8 p-4 bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation text-white"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $pendingCount }} listing(s) need review</p>
                        <p class="text-sm text-gray-600 mt-1">Some vendors are waiting for approval</p>
                        <a href="{{ route('admin.listings.pending') }}" 
                           class="inline-block mt-3 px-4 py-2 bg-gradient-to-r from-pink-600 to-rose-600 text-white text-sm font-medium rounded-lg hover:opacity-90">
                            Review Now
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Platform Stats -->
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Platform Overview</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ \App\Models\Listing::count() }}</p>
                        <p class="text-sm text-gray-600">Total Listings</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ \App\Models\Listing::where('status', 'approved')->count() }}</p>
                        <p class="text-sm text-gray-600">Active Listings</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ \App\Models\User::count() }}</p>
                        <p class="text-sm text-gray-600">Total Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for real-time updates -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update pending count badge in sidebar
    function updatePendingBadge() {
        fetch('{{ route("admin.listings.pending-count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('pending-count');
                if (badge) {
                    badge.textContent = data.count;
                    
                    // Update alert if exists
                    const alertElement = document.querySelector('[data-pending-alert]');
                    if (alertElement && data.count > 0) {
                        alertElement.innerHTML = `<strong>${data.count} listing(s)</strong> need review`;
                    }
                }
            })
            .catch(error => console.error('Error updating pending count:', error));
    }
    
    // Update every 30 seconds
    setInterval(updatePendingBadge, 30000);
    
    // Initial update
    updatePendingBadge();
});
</script>
@endsection