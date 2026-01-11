{{-- resources/views/admin/components/header-admin.blade.php --}}

<header x-data="{ mobileMenuOpen: false, notificationsOpen: false, userMenuOpen: false }">
    <!-- Top Navigation Bar -->
    <nav class="bg-gradient-to-r from-pink-900 to-rose-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Logo & Brand -->
                <div class="flex items-center">
                    <!-- Mobile menu button (hidden on desktop) -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden text-white p-2 rounded-md hover:bg-pink-800 focus:outline-none">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Logo -->
                    <div class="flex items-center ml-3 md:ml-0">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-heart text-pink-600 text-xl"></i>
                            </div>
                            <div class="hidden md:block">
                                <h1 class="text-white font-bold text-xl">WeddingKita</h1>
                                <p class="text-pink-200 text-xs">Admin Panel</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Center: Desktop Navigation (hidden on mobile) -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-pink-800 text-white' : 'text-pink-100 hover:bg-pink-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.listings.pending') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.listings.*') ? 'bg-pink-800 text-white' : 'text-pink-100 hover:bg-pink-800 hover:text-white' }}">
                        <i class="fas fa-list mr-2"></i>
                        Listings
                        @php
                            $pendingCount = \App\Models\Listing::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                        <span class="ml-1 bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $pendingCount }}
                        </span>
                        @endif
                    </a>
                    
                    <a href="#" 
                       class="px-4 py-2 text-sm font-medium rounded-lg text-pink-100 hover:bg-pink-800 hover:text-white">
                        <i class="fas fa-store mr-2"></i>
                        Vendors
                    </a>
                    
                    <a href="#" 
                       class="px-4 py-2 text-sm font-medium rounded-lg text-pink-100 hover:bg-pink-800 hover:text-white">
                        <i class="fas fa-users mr-2"></i>
                        Users
                    </a>
                </div>

                <!-- Right: User Menu -->
                <div class="flex items-center space-x-3">
                    <!-- Notifications -->
                    <div class="relative">
                        <button @click="notificationsOpen = !notificationsOpen" 
                                class="text-pink-200 hover:text-white p-2 rounded-full hover:bg-pink-800 focus:outline-none">
                            <i class="fas fa-bell text-lg"></i>
                            @if($pendingCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                {{ $pendingCount }}
                            </span>
                            @endif
                        </button>
                        
                        <!-- Dropdown Notifications -->
                        <div x-show="notificationsOpen" 
                             @click.away="notificationsOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-2 z-50 border">
                            <div class="px-4 py-2 border-b">
                                <h3 class="font-bold text-gray-900">Notifications</h3>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @if($pendingCount > 0)
                                <a href="{{ route('admin.listings.pending') }}" 
                                   class="flex items-start px-4 py-3 hover:bg-gray-50 border-b">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-clock text-yellow-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $pendingCount }} listing(s) pending review
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Click to review and approve listings
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">Just now</p>
                                    </div>
                                </a>
                                @endif
                                
                                @if($pendingCount === 0)
                                <div class="px-4 py-6 text-center">
                                    <i class="fas fa-check-circle text-3xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">No new notifications</p>
                                </div>
                                @endif
                            </div>
                            
                            <div class="px-4 py-2 border-t">
                                <a href="#" class="text-sm text-pink-600 hover:text-pink-800 font-medium">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 flex items-center justify-center">
                                <span class="text-white font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-pink-200">Administrator</p>
                            </div>
                            <i class="fas fa-chevron-down text-pink-200 hidden md:block"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-50 border">
                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2 text-gray-400"></i>
                                My Profile
                            </a>
                            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="border-t my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (hidden by default) -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="md:hidden border-t border-pink-800">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-pink-800 text-white' : 'text-pink-100 hover:bg-pink-800 hover:text-white' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.listings.pending') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.listings.*') ? 'bg-pink-800 text-white' : 'text-pink-100 hover:bg-pink-800 hover:text-white' }}">
                    <i class="fas fa-list mr-2"></i>
                    Listings
                    @if($pendingCount > 0)
                    <span class="ml-2 bg-rose-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $pendingCount }}
                    </span>
                    @endif
                </a>
                
                <a href="#" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-pink-100 hover:bg-pink-800 hover:text-white">
                    <i class="fas fa-store mr-2"></i>
                    Vendors
                </a>
                
                <a href="#" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-pink-100 hover:bg-pink-800 hover:text-white">
                    <i class="fas fa-users mr-2"></i>
                    Users
                </a>
                
                <div class="border-t border-pink-800 mt-2 pt-2">
                    <a href="#" 
                       class="block px-3 py-2 rounded-md text-base font-medium text-pink-100 hover:bg-pink-800 hover:text-white">
                        <i class="fas fa-user mr-2"></i>
                        My Profile
                    </a>
                    
                    <a href="#" 
                       class="block px-3 py-2 rounded-md text-base font-medium text-pink-100 hover:bg-pink-800 hover:text-white">
                        <i class="fas fa-cog mr-2"></i>
                        Settings
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-pink-100 hover:bg-pink-800 hover:text-white">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>