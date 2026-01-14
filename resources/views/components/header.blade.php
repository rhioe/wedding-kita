{{-- resources\views\components\header.blade.php --}}
<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-rose-600 rounded-lg"></div>
                <span class="text-xl font-bold text-gray-900">WeddingKita</span>
            </a>
            
            <!-- Desktop Search -->
            <div class="hidden md:block flex-1 max-w-2xl mx-8">
                @livewire('search.search-bar')
            </div>
            
            <!-- Auth Links -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="/dashboard" class="text-gray-700 hover:text-rose-600 font-medium">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-rose-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-rose-600 font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-rose-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-rose-700">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</header>