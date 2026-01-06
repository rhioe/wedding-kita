<nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Left: Logo & Navigation -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Wedding<span class="text-pink-600">Kita</span></span>
                </a>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('vendor.dashboard') }}" 
                       class="text-gray-700 hover:text-pink-600 font-medium transition-colors {{ request()->routeIs('vendor.dashboard') ? 'text-pink-600' : '' }}">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('vendor.listings.index') }}" 
                       class="text-gray-700 hover:text-pink-600 font-medium transition-colors {{ request()->routeIs('vendor.listings.*') ? 'text-pink-600' : '' }}">
                        <i class="fas fa-list mr-2"></i>My Listings
                    </a>
                    <a href="{{ route('vendor.leads.index') }}" 
                       class="text-gray-700 hover:text-pink-600 font-medium transition-colors">
                        <i class="fas fa-inbox mr-2"></i>Leads
                        <span class="ml-1 px-2 py-0.5 bg-pink-100 text-pink-800 text-xs rounded-full">0</span>
                    </a>
                </div>
            </div>

            <!-- Right: User Menu -->
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <button class="relative p-2 text-gray-600 hover:text-pink-600 transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <!-- Avatar -->
                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        
                        <!-- User Info -->
                        <div class="hidden md:block text-left">
                            <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-store text-xs"></i>
                                    Vendor
                                </span>
                            </p>
                        </div>
                        
                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                        
                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="{{ route('vendor.dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-tachometer-alt text-gray-400 w-5"></i>
                                <span>Dashboard</span>
                            </a>
                            
                            <a href="{{ route('vendor.profile.complete') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-edit text-gray-400 w-5"></i>
                                <span>Edit Profile</span>
                            </a>
                            
                            <a href="{{ route('vendor.settings') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-cog text-gray-400 w-5"></i>
                                <span>Settings</span>
                            </a>
                            
                            <a href="#" 
                               class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-question-circle text-gray-400 w-5"></i>
                                <span>Help & Support</span>
                            </a>
                        </div>

                        <!-- Footer -->
                        <div class="border-t border-gray-100 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden border-t border-gray-200 mt-2 pt-2">
            <div class="flex justify-around">
                <a href="{{ route('vendor.dashboard') }}" 
                   class="flex flex-col items-center p-2 text-gray-600 hover:text-pink-600">
                    <i class="fas fa-home mb-1"></i>
                    <span class="text-xs">Dashboard</span>
                </a>
                <a href="{{ route('vendor.listings.index') }}" 
                   class="flex flex-col items-center p-2 text-gray-600 hover:text-pink-600">
                    <i class="fas fa-list mb-1"></i>
                    <span class="text-xs">Listings</span>
                </a>
                <a href="{{ route('vendor.leads.index') }}" 
                   class="flex flex-col items-center p-2 text-gray-600 hover:text-pink-600">
                    <i class="fas fa-inbox mb-1"></i>
                    <span class="text-xs">Leads</span>
                </a>
                <a href="{{ route('vendor.profile.complete') }}" 
                   class="flex flex-col items-center p-2 text-gray-600 hover:text-pink-600">
                    <i class="fas fa-user mb-1"></i>
                    <span class="text-xs">Profile</span>
                </a>
            </div>
        </div>
    </div>
</nav>