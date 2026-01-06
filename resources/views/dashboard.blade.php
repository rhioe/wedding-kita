@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    
    @if(auth()->user()->role === 'user')
        <!-- Dashboard Calon Pengantin -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">👰 Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600 mb-6">Anda terdaftar sebagai <span class="font-bold">Calon Pengantin</span></p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-pink-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">💬</div>
                    <h3 class="font-bold">Vendor Dihubungi</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-pink-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">📅</div>
                    <h3 class="font-bold">Booking Aktif</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-pink-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">⭐</div>
                    <h3 class="font-bold">Favorit</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>
            </div>
            
            <div class="mt-8">
                <a href="/listings" class="bg-pink-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-pink-700">
                    🔍 Cari Vendor
                </a>
            </div>
        </div>
        
    @elseif(auth()->user()->role === 'vendor')
        <!-- Dashboard Vendor -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">💼 Dashboard Vendor</h2>
            <p class="text-gray-600 mb-6">Selamat datang, {{ auth()->user()->name }}!</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">📋</div>
                    <h3 class="font-bold">Total Listings</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">💬</div>
                    <h3 class="font-bold">Leads Hari Ini</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl mb-2">💰</div>
                    <h3 class="font-bold">Pendapatan</h3>
                    <p class="text-3xl font-bold mt-2">Rp 0</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <a href="/vendor/listings/create" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-bold hover:bg-blue-700">
                    ➕ Buat Listing Baru
                </a>
                <a href="/vendor/listings" class="block w-full border border-blue-600 text-blue-600 text-center py-3 rounded-lg font-bold hover:bg-blue-50">
                    📋 Kelola Listings
                </a>
            </div>
        </div>
        
    @elseif(auth()->user()->role === 'admin')
        <!-- Dashboard Admin -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">👑 Admin Dashboard</h2>
            <p class="text-gray-600 mb-6">Halo, Admin!</p>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-bold">Total Users</h3>
                    <p class="text-2xl font-bold mt-2">1</p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-bold">Total Vendors</h3>
                    <p class="text-2xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-bold">Pending Listings</h3>
                    <p class="text-2xl font-bold mt-2">0</p>
                </div>
                
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-bold">Revenue</h3>
                    <p class="text-2xl font-bold mt-2">Rp 0</p>
                </div>
            </div>
            
            <div class="mt-8">
                <a href="/admin/listings/pending" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-900">
                    ⚡ Review Pending Listings
                </a>
            </div>
        </div>
    @endif
</div>
@endsection