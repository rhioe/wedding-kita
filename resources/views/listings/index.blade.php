<?php
// resources/views/listings/index.blade.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Vendors - WeddingKita</title>
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F6E7E1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="https://via.placeholder.com/152x152/F6E7E1/2F2F2F?text=WK">
    <meta name="apple-mobile-web-app-title" content="WeddingKita">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-rose-600">WeddingKita</a>
                <div class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Cari vendor, lokasi, atau kategori..." 
                               class="w-full border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-rose-500">
                        <button class="absolute right-3 top-3 text-gray-400">
                            🔍
                        </button>
                    </div>
                </div>
                <div class="space-x-4">
                    <a href="/login" class="text-gray-600 hover:text-rose-600">Login</a>
                    <a href="/register" class="bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4">Filter Pencarian</h3>
                    
                    <!-- Category Filter -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Kategori</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="category" value="all" checked class="mr-2">
                                <span>Semua Kategori</span>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="radio" name="category" value="{{ $category->name }}" class="mr-2">
                                <span>{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Rentang Harga</h4>
                        <div class="space-y-2">
                            <input type="range" min="0" max="100000000" class="w-full">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Rp 0</span>
                                <span>Rp 100jt+</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-3">Lokasi</h4>
                        <input type="text" placeholder="Kota atau daerah..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    
                    <button class="w-full bg-rose-600 text-white py-3 rounded-lg hover:bg-rose-700">
                        Terapkan Filter
                    </button>
                </div>
            </aside>

            <!-- Listing Grid -->
            <main class="lg:w-3/4">
                <!-- Results Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Semua Vendor</h1>
                        <p class="text-gray-600">{{ $listings->total() }} vendor ditemukan</p>
                    </div>
                    <div>
                        <select class="border border-gray-300 rounded-lg px-4 py-2">
                            <option value="newest">Terbaru</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                            <option value="popular">Paling Populer</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($listings as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="group">
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                            <!-- Image -->
                            <div class="h-56 bg-gray-200 relative">
                                @if($listing->photos->count() > 0)
                                    <img src="{{ asset('storage/' . $listing->photos->first()->path) }}" 
                                         alt="{{ $listing->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <span class="text-gray-400">📷</span>
                                    </div>
                                @endif
                                @if($listing->is_featured)
                                <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                    Unggulan
                                </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-800 group-hover:text-rose-600">{{ $listing->title }}</h3>
                                        <p class="text-gray-600 text-sm mt-1">{{ $listing->vendor->business_name ?? 'Vendor' }}</p>
                                    </div>
                                    <div class="text-rose-600 font-bold">
                                        Rp {{ number_format($listing->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <div class="flex items-center text-gray-500 text-sm mt-3">
                                    <span class="mr-4">📍 {{ $listing->location }}</span>
                                    <span>👁️ {{ $listing->views_count }} dilihat</span>
                                </div>
                                
                                <div class="mt-4">
                                    <button class="w-full bg-rose-50 text-rose-600 font-semibold py-2 rounded-lg hover:bg-rose-100 transition-colors">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <!-- Empty State -->
                    <div class="col-span-3 text-center py-12">
                        <div class="text-5xl mb-4">🔍</div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada vendor tersedia</h3>
                        <p class="text-gray-600">Jadilah vendor pertama di WeddingKita!</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($listings->hasPages())
                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="text-center text-gray-400">
                © 2024 WeddingKita. All rights reserved.
            </div>
        </div>
    </footer>
    <!-- Mobile Bottom Navigation -->
@include('components.mobile.bottom-nav')
<!-- PWA Service Worker Registration -->
<script>
// Register Service Worker
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('{{ asset('sw.js') }}')
      .then(function(registration) {
        console.log('✅ ServiceWorker registration successful:', registration.scope);
        
        // Check if PWA is installable
        window.addEventListener('beforeinstallprompt', (e) => {
          console.log('📲 PWA install prompt available');
          // You can show custom install button here later
        });
      })
      .catch(function(err) {
        console.log('❌ ServiceWorker registration failed:', err);
      });
  });
}

// PWA Install Prompt (optional custom button)
function installPWA() {
  if (window.deferredPrompt) {
    window.deferredPrompt.prompt();
    window.deferredPrompt.userChoice.then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted PWA install');
      }
      window.deferredPrompt = null;
    });
  }
}
</script>
</body>
</html>