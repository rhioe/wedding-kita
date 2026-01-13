<?php
// resources/views/home.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeddingKita - Marketplace Vendor Pernikahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Simple Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-rose-600">WeddingKita</div>
                <div class="space-x-4">
                    <a href="/login" class="text-gray-600 hover:text-rose-600">Login</a>
                    <a href="/register" class="bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Temukan Vendor Pernikahan Terbaik
            </h1>
            <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                Ribuan fotografer, venue, makeup artist, dan vendor pernikahan siap membuat hari istimewa Anda sempurna.
            </p>
            <div class="max-w-md mx-auto">
                <div class="flex gap-2">
                    <input type="text" placeholder="Cari vendor atau layanan..." 
                           class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <button class="bg-rose-600 text-white px-6 py-3 rounded-lg hover:bg-rose-700">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Categories -->
    <section class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Cari Berdasarkan Kategori</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach(['Fotografer', 'Venue', 'Catering', 'Makeup', 'Dekorasi', 'WO'] as $category)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow cursor-pointer">
                <div class="text-3xl mb-2">📷</div>
                <div class="font-medium text-gray-700">{{ $category }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Listings -->
    <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Vendor Unggulan</h2>
            <a href="/listings" class="text-rose-600 hover:text-rose-700">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if(isset($featuredListings) && count($featuredListings) > 0)
                @foreach($featuredListings as $listing)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="h-48 bg-gray-200"></div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800">{{ $listing->title }}</h3>
                        <p class="text-rose-600 font-semibold mt-2">Rp {{ number_format($listing->price, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $listing->location }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Placeholder jika belum ada data -->
                @for($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="h-48 bg-gray-100 animate-pulse"></div>
                    <div class="p-4">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2 animate-pulse"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2 animate-pulse"></div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </section>

    <!-- Popular Listings -->
    <section class="max-w-7xl mx-auto px-4 py-8 bg-white mt-8 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Populer Minggu Ini</h2>
            <a href="/listings?sort=popular" class="text-rose-600 hover:text-rose-700">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if(isset($popularListings) && count($popularListings) > 0)
                @foreach($popularListings as $listing)
                <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200 hover:border-rose-300 transition-colors">
                    <div class="h-40 bg-gray-300"></div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800">{{ $listing->title }}</h3>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-rose-600 font-bold">Rp {{ number_format($listing->price, 0, ',', '.') }}</span>
                            <span class="text-gray-500 text-sm">{{ $listing->views_count }} dilihat</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Placeholder jika belum ada data -->
                @for($i = 0; $i < 4; $i++)
                <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                    <div class="h-40 bg-gray-200 animate-pulse"></div>
                    <div class="p-4">
                        <div class="h-4 bg-gray-300 rounded w-full mb-2 animate-pulse"></div>
                        <div class="flex justify-between">
                            <div class="h-4 bg-gray-300 rounded w-1/3 animate-pulse"></div>
                            <div class="h-4 bg-gray-300 rounded w-1/4 animate-pulse"></div>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-2xl font-bold mb-4">WeddingKita</div>
                    <p class="text-gray-400">Platform terpercaya untuk menemukan vendor pernikahan terbaik di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/about" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="/contact" class="hover:text-white">Kontak</a></li>
                        <li><a href="/privacy" class="hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="/terms" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kategori</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Fotografer</li>
                        <li>Venue</li>
                        <li>Catering</li>
                        <li>Makeup Artist</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                © 2024 WeddingKita. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>