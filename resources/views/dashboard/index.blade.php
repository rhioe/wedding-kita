@extends('layouts.app')

@section('title', 'Dashboard - WeddingKita')

@section('content')
<div class="py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Welcome back, {{ auth()->user()->name }}!
        </h1>
        <p class="text-gray-600">Here's what's happening with your account today.</p>
    </div>

    <!-- USER DASHBOARD -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Start Planning Your Wedding</h2>
                <p class="text-gray-600 max-w-lg mx-auto">
                    Browse our verified vendors to make your special day perfect.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="/listings?category=photographer" 
                   class="group">
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100 rounded-xl p-6 text-center hover:shadow-lg transition-all">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-camera text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Photographers</h3>
                        <p class="text-sm text-gray-600">Capture perfect moments</p>
                    </div>
                </a>

                <a href="/listings?category=venue" 
                   class="group">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-xl p-6 text-center hover:shadow-lg transition-all">
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-building text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Venues</h3>
                        <p class="text-sm text-gray-600">Find perfect locations</p>
                    </div>
                </a>

                <a href="/listings?category=catering" 
                   class="group">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100 rounded-xl p-6 text-center hover:shadow-lg transition-all">
                        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-utensils text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Catering</h3>
                        <p class="text-sm text-gray-600">Delicious food & drinks</p>
                    </div>
                </a>
            </div>

            <div class="mt-10 text-center">
                <a href="/listings" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-rose-600 text-white px-8 py-3.5 rounded-lg font-bold hover:opacity-90 transition-all shadow-lg hover:shadow-xl">
                    <i class="fas fa-search"></i>
                    Browse All Vendors
                </a>
            </div>
        </div>
    </div>
</div>
@endsection