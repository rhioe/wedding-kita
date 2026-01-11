{{-- resources\views\home.blade.php --}}

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WeddingKita - Marketplace vendor pernikahan terpercaya">
    
    <title>@yield('title', 'WeddingKita')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-sm border-b">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ring text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                        WeddingKita
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-gray-700 hover:text-pink-600 font-medium transition-colors">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="/listings" class="text-gray-700 hover:text-pink-600 font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Browse
                    </a>
                    <a href="/vendors" class="text-gray-700 hover:text-pink-600 font-medium transition-colors">
                        <i class="fas fa-store mr-2"></i>For Vendors
                    </a>
                    
                    @auth
                        <div class="flex items-center gap-4 ml-4">
                            <a href="/dashboard" class="text-gray-700 hover:text-pink-600 font-medium">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-pink-600 font-medium">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-4 ml-4">
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-600 to-rose-600 text-white px-5 py-2 rounded-lg font-medium hover:opacity-90 transition-all shadow-sm">
                                <i class="fas fa-user-plus mr-2"></i>Register
                            </a>
                        </div>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bars text-xl text-gray-700"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" x-cloak class="md:hidden border-t py-4">
                <div class="flex flex-col gap-3">
                    <a href="/" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-home w-5 text-gray-500"></i>
                        <span>Home</span>
                    </a>
                    <a href="/listings" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-search w-5 text-gray-500"></i>
                        <span>Browse</span>
                    </a>
                    <a href="/vendors" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-store w-5 text-gray-500"></i>
                        <span>For Vendors</span>
                    </a>
                    
                    @auth
                        <div class="pt-3 mt-3 border-t">
                            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">
                                <i class="fas fa-tachometer-alt w-5 text-gray-500"></i>
                                <span>Dashboard</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="pt-3 mt-3 border-t space-y-2">
                            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg border">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg bg-gradient-to-r from-pink-600 to-rose-600 text-white">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-200px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-ring text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold">WeddingKita</h3>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Platform terpercaya untuk menemukan vendor pernikahan terbaik.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">For Couples</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Find Vendors</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Wedding Tips</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Budget Planner</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">For Vendors</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Vendor Dashboard</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Marketing Tips</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope w-5"></i>
                            <span>hello@weddingkita.id</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fab fa-whatsapp w-5"></i>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-sm">
                <p>© 2024 WeddingKita. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mobileMenu', false);
        });
    </script>
    
    @stack('scripts')
</body>
</html>