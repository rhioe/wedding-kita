<?php
// resources/views/components/mobile/bottom-nav.blade.php
?>
<!-- Mobile Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-200 shadow-2xl z-50 md:hidden">
    <div class="flex justify-around items-center h-16 px-2">
        <!-- Home -->
        <a href="{{ url('/') }}" 
           class="flex flex-col items-center justify-center w-1/4 h-full transition-all duration-200 {{ request()->is('/') ? 'text-rose-600' : 'text-gray-500 hover:text-rose-500' }}">
            <div class="text-2xl mb-0.5 transform transition-transform {{ request()->is('/') ? 'scale-110' : '' }}">
                @if(request()->is('/')) 🏠 @else 🏠 @endif
            </div>
            <span class="text-xs font-medium">Home</span>
        </a>
        
        <!-- Browse -->
        <a href="{{ route('listings.index') }}" 
           class="flex flex-col items-center justify-center w-1/4 h-full transition-all duration-200 {{ request()->is('listings') ? 'text-rose-600' : 'text-gray-500 hover:text-rose-500' }}">
            <div class="text-2xl mb-0.5 transform transition-transform {{ request()->is('listings') ? 'scale-110' : '' }}">
                @if(request()->is('listings')) 🔍 @else 🔍 @endif
            </div>
            <span class="text-xs font-medium">Browse</span>
        </a>
        
        <!-- Favorites (Coming Soon) -->
        <a href="#" 
           class="flex flex-col items-center justify-center w-1/4 h-full text-gray-400 transition-all duration-200 hover:text-rose-400">
            <div class="text-2xl mb-0.5 relative">
                ❤️
                <span class="absolute -top-1 -right-1 text-[10px] bg-rose-500 text-white px-1 rounded-full">soon</span>
            </div>
            <span class="text-xs font-medium">Favorites</span>
        </a>
        
        <!-- Profile / Login -->
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" 
           class="flex flex-col items-center justify-center w-1/4 h-full transition-all duration-200 {{ request()->is('dashboard*', 'login*', 'register*') ? 'text-rose-600' : 'text-gray-500 hover:text-rose-500' }}">
            <div class="text-2xl mb-0.5 transform transition-transform {{ request()->is('dashboard*', 'login*', 'register*') ? 'scale-110' : '' }}">
                @if(auth()->check()) 👤 @else 👤 @endif
            </div>
            <span class="text-xs font-medium">{{ auth()->check() ? 'Profile' : 'Login' }}</span>
        </a>
    </div>
</nav>

<!-- Spacer agar konten tidak tertutup bottom nav -->
<div class="h-16 md:h-0"></div>

<style>
/* Smooth animation for active state */
nav a.active {
    transform: translateY(-4px);
}

/* Better touch targets */
nav a {
    min-height: 44px;
    min-width: 44px;
}

/* iOS safe area for notch phones */
@supports (padding-bottom: env(safe-area-inset-bottom)) {
    nav {
        padding-bottom: env(safe-area-inset-bottom);
    }
    .h-16 {
        height: calc(4rem + env(safe-area-inset-bottom));
    }
}
</style>