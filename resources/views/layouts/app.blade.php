<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WeddingKita - Your Perfect Wedding Marketplace')</title>
    <meta name="description" content="Find the best wedding vendors in Indonesia. Photographers, venues, catering, decoration, and more for your special day.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS for dropdowns & interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Additional Styles -->
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #ec4899;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #db2777;
        }
        
        /* Animation for fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    
    @stack('styles')
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 fade-in">
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-lg max-w-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600"></i>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 z-50 fade-in">
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg max-w-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <div>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="fixed top-4 right-4 z-50 fade-in">
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg max-w-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
                <div>
                    <p class="font-medium mb-1">Please fix the following errors:</p>
                    <ul class="text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Header Section -->
    <header>
        @auth
            @if(auth()->user()->role === 'vendor')
                @include('vendor.components.header')
            @elseif(auth()->user()->role === 'admin')
                {{-- @include('components.header-admin') --}}
                @include('components.header') <!-- Temporary pakai guest header -->
            @else
                @include('components.header') <!-- User biasa pakai guest header dulu -->
            @endif
        @else
            @include('components.header')
        @endauth
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Scripts -->
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.fixed.top-4');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });

            // Mobile menu toggle (if needed)
            const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
    
    @stack('scripts')

       {{ $slot ?? '' }}
    
    @livewireScripts
</body>
</html>