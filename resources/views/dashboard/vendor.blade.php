@extends('layouts.app')

@section('title', 'Vendor Dashboard - WeddingKita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-pink-50 pt-16">
    <div class="container mx-auto px-4 py-8">
        
        <!-- ========== WELCOME BANNER ========== -->
        <div class="bg-gradient-to-r from-pink-500 via-rose-500 to-orange-500 rounded-2xl shadow-xl p-6 md:p-8 mb-8 text-white overflow-hidden relative">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
                <i class="fas fa-heart text-9xl"></i>
            </div>
            
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">
                            Welcome back, {{ $vendor->business_name ?? auth()->user()->name }}! 👋
                        </h1>
                        <p class="opacity-90">Here's what's happening with your wedding business today.</p>
                        
                        <!-- Profile Progress -->
                        <div class="mt-6 max-w-md">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Profile Completion</span>
                                <span class="font-bold">{{ round($profile_completion) }}%</span>
                            </div>
                            <div class="w-full bg-white/30 rounded-full h-3">
                                <div class="bg-white h-3 rounded-full" style="width: {{ $profile_completion }}%"></div>
                            </div>
                            @if($profile_completion < 100)
                            <p class="text-sm mt-2 opacity-90">
                                Complete your profile to get more visibility
                            </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if($profile_completion < 100)
                        <a href="{{ route('vendor.profile.complete') }}" 
                           class="bg-white text-pink-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl text-center">
                            <i class="fas fa-user-edit mr-2"></i>Complete Profile
                        </a>
                        @endif
                        <a href="{{ route('vendor.listings.create') }}" 
                           class="bg-black/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-lg font-bold hover:bg-black/30 transition-all shadow-lg hover:shadow-xl text-center">
                            <i class="fas fa-plus mr-2"></i>Create Listing
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- ========== LEFT SIDEBAR ========== -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-rose-500 rounded-xl flex items-center justify-center text-white text-2xl font-bold">
                                @if($vendor->profile_photo)
                                    <img src="{{ asset('storage/' . $vendor->profile_photo) }}" 
                                         alt="{{ $vendor->business_name }}" 
                                         class="w-16 h-16 rounded-xl object-cover">
                                @else
                                    {{ strtoupper(substr($vendor->business_name, 0, 1)) }}
                                @endif
                            </div>
                            @if($vendor->status === 'active')
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $vendor->business_name }}</h3>
                            <p class="text-sm text-gray-500 flex items-center gap-1">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $vendor->location ?? 'Not set' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Account Status</span>
                            <span class="font-medium px-3 py-1 rounded-full 
                                @if($vendor->status === 'active') bg-green-100 text-green-800
                                @elseif($vendor->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($vendor->status) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium">{{ $vendor->created_at->format('M Y') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Response Rate</span>
                            <span class="font-medium">-</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="{{ route('vendor.listings.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-list text-blue-600"></i>
                            </div>
                            <span class="font-medium">My Listings</span>
                        </a>
                        
                        <a href="{{ route('vendor.leads.index') }}" 
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-inbox text-green-600"></i>
                            </div>
                            <span class="font-medium">Leads & Messages</span>
                        </a>
                        
                        <a href="{{ route('vendor.settings') }}" 
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-cog text-purple-600"></i>
                            </div>
                            <span class="font-medium">Settings</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ========== MAIN CONTENT ========== -->
            <div class="lg:col-span-3 space-y-8">
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Listings -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-list text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['total_listings'] ?? 0 }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Total Listings</h3>
                        <p class="text-sm text-gray-500">Active wedding services</p>
                        <a href="{{ route('vendor.listings.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mt-4 inline-block">
                            View all →
                        </a>
                    </div>

                    <!-- Total Leads -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['total_leads'] ?? 0 }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Total Leads</h3>
                        <p class="text-sm text-gray-500">Customer inquiries</p>
                        <a href="{{ route('vendor.leads.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium mt-4 inline-block">
                            View leads →
                        </a>
                    </div>

                    <!-- Response Rate -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-pink-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">-</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Response Rate</h3>
                        <p class="text-sm text-gray-500">Avg. reply time</p>
                        <span class="text-purple-600 hover:text-purple-700 text-sm font-medium mt-4 inline-block cursor-help">
                            Improve →
                        </span>
                    </div>

                    <!-- Profile Score -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-amber-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-star text-orange-600 text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ round($profile_completion) }}%</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Profile Score</h3>
                        <p class="text-sm text-gray-500">Completion status</p>
                        @if($profile_completion < 100)
                        <a href="{{ route('vendor.profile.complete') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium mt-4 inline-block">
                            Complete →
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Two Columns Content -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
                            <a href="#" class="text-pink-600 hover:text-pink-700 text-sm font-medium">
                                View all →
                            </a>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Activity Item -->
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-blue-50/50">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-check text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Profile Updated</h4>
                                    <p class="text-sm text-gray-500">You updated your business information</p>
                                    <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                </div>
                            </div>
                            
                            <!-- Activity Item -->
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-green-50/50">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-list-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Listing Created</h4>
                                    <p class="text-sm text-gray-500">"Premium Wedding Photography" listing created</p>
                                    <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                </div>
                            </div>
                            
                            <!-- Activity Item -->
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-purple-50/50">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-plus text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Account Activated</h4>
                                    <p class="text-sm text-gray-500">Your vendor account is now active</p>
                                    <p class="text-xs text-gray-400 mt-1">3 days ago</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('vendor.listings.create') }}" 
                               class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-pink-300 hover:bg-pink-50 transition-all group">
                                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-plus text-pink-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-900">Create Listing</span>
                                <span class="text-sm text-gray-500 mt-1">Add new service</span>
                            </a>
                            
                            <a href="{{ route('vendor.profile.complete') }}" 
                               class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-edit text-blue-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-900">Edit Profile</span>
                                <span class="text-sm text-gray-500 mt-1">Update business info</span>
                            </a>
                            
                            <a href="{{ route('vendor.listings.index') }}" 
                               class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all group">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-list text-green-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-900">Manage Listings</span>
                                <span class="text-sm text-gray-500 mt-1">Edit your services</span>
                            </a>
                            
                            <a href="{{ route('vendor.leads.index') }}" 
                               class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all group">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                                </div>
                                <span class="font-medium text-gray-900">View Analytics</span>
                                <span class="text-sm text-gray-500 mt-1">See performance</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== SUPPORT SECTION ========== -->
        <div class="mt-8">
            <div class="bg-gradient-to-r from-gray-900 to-black rounded-2xl shadow-xl p-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-2xl font-bold mb-3">Need Help Growing Your Business?</h3>
                        <p class="text-gray-300 max-w-2xl">
                            Our dedicated support team is here to help you succeed. Get tips on improving your listings, 
                            increasing leads, and maximizing your earnings.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="https://wa.me/6281234567890" target="_blank"
                           class="bg-white text-gray-900 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl text-center">
                            <i class="fab fa-whatsapp mr-2"></i>Chat on WhatsApp
                        </a>
                        <a href="mailto:support@weddingkita.com"
                           class="bg-transparent border border-white/30 text-white px-6 py-3 rounded-lg font-bold hover:bg-white/10 transition-all text-center">
                            <i class="fas fa-envelope mr-2"></i>Email Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection