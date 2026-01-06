@props(['title' => 'WeddingKita'])

<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-pink-600 rounded-lg"></div>
                    <span class="text-xl font-semibold text-gray-900">{{ $title }}</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-700 hover:text-pink-600 font-medium">Beranda</a>
                <a href="/listings" class="text-gray-700 hover:text-pink-600 font-medium">Cari Vendor</a>
                <a href="/vendors" class="text-gray-700 hover:text-pink-600 font-medium">Untuk Vendor</a>
                
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="/dashboard" class="text-gray-700 hover:text-pink-600 font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-pink-600 font-medium">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-pink-700">Daftar Vendor</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-cloak class="md:hidden border-t">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Beranda</a>
            <a href="/listings" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Cari Vendor</a>
            <a href="/vendors" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Untuk Vendor</a>
            
            @auth
                <a href="/dashboard" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md bg-pink-600 text-white hover:bg-pink-700">Daftar Vendor</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('open', false);
    });
</script>