
{{-- resources/views/livewire/search/search-listings.blade.php --}}


<div class="min-h-screen bg-gray-50">
    <!-- ==================== MOBILE LAYOUT ==================== -->
    
    <!-- Mobile Search Bar (Default: show, Hidden on FHD+) -->
    <div class="2xl:hidden bg-white border-b px-4 py-3">
        <div class="relative">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="q"
                placeholder="Cari vendor..." 
                class="w-full border border-gray-300 rounded-full px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"
            >
            <div class="absolute right-3 top-2.5 text-gray-400">
                @if($q)
                    <button wire:click="$set('q', '')" class="mr-1 hover:text-gray-600 text-sm">
                        ✕
                    </button>
                @endif
                <span class="text-sm">🔍</span>
            </div>
        </div>
    </div>

    <x-responsive-container size="default" padding="default">
        <div class="py-4 sm:py-6">
            <!-- Mobile Filter Toggle (Default: show, Hidden on FHD+) -->
            <div class="flex justify-between items-center mb-4 2xl:hidden">
                <div>
                    <h1 class="text-lg font-bold text-gray-800 sm:text-xl">
                        @if($q && strlen($q) >= 2)
                            Hasil Pencarian
                        @else
                            Semua Vendor
                        @endif
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">
                        <span class="font-medium">{{ $listings->total() }}</span> ditemukan
                    </p>
                </div>
                
                <button 
                    @click="$wire.showFilters = true"
                    class="flex items-center gap-2 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 text-sm"
                >
                    <span>Filter</span>
                    <span>⚙️</span>
                </button>
            </div>

            <!-- Sort Dropdown (Mobile & Desktop) -->
            <div class="mb-4">
                <div class="relative inline-block">
                    <select wire:model.live="sort" 
                            class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm appearance-none pr-8 bg-white focus:outline-none focus:ring-2 focus:ring-rose-500 w-full sm:w-auto">
                        <option value="newest">Terbaru</option>
                        <option value="price_low">Harga Terendah</option>
                        <option value="price_high">Harga Tertinggi</option>
                        <option value="popular">Paling Populer</option>
                        <option value="featured">Unggulan</option>
                    </select>
                    <div class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- ==================== MAIN CONTENT ==================== -->
            <div class="flex flex-col 2xl:flex-row gap-6">
                <!-- Desktop Filters Sidebar (Hidden on mobile, Show on FHD+) -->
                <aside class="hidden 2xl:block 2xl:w-80 flex-shrink-0">
                    <x-card variant="default" padding="default" class="sticky top-6">
                        <!-- Filter Header -->
                        <div class="flex justify-between items-center mb-5 pb-4 border-b border-gray-100">
                            <h2 class="font-bold text-gray-800">Filter</h2>
                            <button wire:click="clearFilters" class="text-sm text-rose-600 hover:text-rose-700">
                                Reset
                            </button>
                        </div>

                        <!-- Filters Content -->
                        @include('livewire.search.partials.filters-desktop')
                    </x-card>
                </aside>

                <!-- Results Area (Full width on mobile, Flexible on desktop) -->
                <main class="flex-1 min-w-0">
                    <!-- Desktop Header (Hidden on mobile) -->
                    <x-card variant="default" padding="default" class="mb-6 hidden 2xl:block">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">
                                    @if($q && strlen($q) >= 2)
                                        Hasil Pencarian
                                    @else
                                        Semua Vendor
                                    @endif
                                </h1>
                                <p class="text-gray-600 mt-1">
                                    <span class="font-medium">{{ $listings->total() }}</span> vendor ditemukan
                                    @if($q && strlen($q) >= 2)
                                        untuk "<span class="font-medium">{{ $q }}</span>"
                                    @endif
                                </p>
                            </div>
                        </div>
                    </x-card>

                    <!-- Results Grid - MOBILE FIRST -->
                    @if($listings->count() > 0)
                        <x-grid-container columns="responsive" gap="default">
                            @foreach($listings as $listing)
                                <x-card variant="hover" padding="tight" class="h-full">
                                    @include('components.listing-card', ['listing' => $listing])
                                </x-card>
                            @endforeach
                        </x-grid-container>

                        <!-- Pagination -->
                        @if($listings->hasPages())
                            <div class="mt-8">
                                {{ $listings->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <x-empty-state 
                            icon="🔍"
                            title="Tidak ada hasil ditemukan"
                            description="Coba gunakan kata kunci lain atau kurangi filter"
                            action="\$wire.clearFilters()"
                            actionText="Reset semua filter"
                        />
                    @endif
                </main>
            </div>
        </div>
    </x-responsive-container>

    <!-- ==================== MOBILE FILTER DRAWER ==================== -->
    @if($showFilters)
        <div class="fixed inset-0 z-50 2xl:hidden" x-data>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50" @click="$wire.showFilters = false"></div>
            
            <!-- Drawer -->
            <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl p-5 max-h-[85vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-5 pb-4 border-b">
                    <h2 class="text-lg font-bold text-gray-800">Filter</h2>
                    <button @click="$wire.showFilters = false" class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>

                <!-- Mobile Filters Content -->
                @include('livewire.search.partials.filters-mobile')
            </div>
        </div>
    @endif

    <!-- ==================== LOADING SKELETON ==================== -->
    <div wire:loading class="fixed inset-0 bg-white/80 flex items-center justify-center z-50">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-rose-600 mx-auto mb-4"></div>
            <p class="text-gray-700 font-medium">Memuat...</p>
        </div>
    </div>
</div>