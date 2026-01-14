<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F6E7E1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('img/icon-192.png') }}">
    <meta name="apple-mobile-web-app-title" content="WeddingKita">
    
    <!-- Title -->
    <title>@yield('title', 'WeddingKita - Marketplace Vendor Pernikahan')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Livewire -->
    @livewireStyles
    
    <!-- Global Styles -->
    <style>
        :root {
            --primary: #F6E7E1;
            --secondary: #E8D8C4;
            --accent: #CFA5A5;
            --text: #2F2F2F;
            --muted: #8A8A8A;
            --bg: #FAFAFA;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Consistent form elements */
        select, input, textarea, button {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
        
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        /* Consistent focus styles */
        .focus-ring:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            --tw-ring-color: var(--accent);
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }
        
        /* Consistent transitions */
        .transition-default {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }

        /* Search container consistency */
.search-container {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.search-container * {
    box-sizing: border-box;
}

    </style>
    
    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    @include('components.header')
    
    <!-- Main Content -->
    <main class="min-h-[calc(100vh-140px)]">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('components.footer')
    
    <!-- Mobile Bottom Navigation -->
    @include('components.mobile.bottom-nav')
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- PWA Service Worker -->
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('{{ asset('sw.js') }}')
                .catch(function(err) {
                    console.log('ServiceWorker registration failed:', err);
                });
        });
    }
    </script>
    
    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>