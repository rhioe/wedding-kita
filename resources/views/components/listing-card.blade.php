{{-- resources\views\components\listing-card.blade.php --}}

@props(['listing'])

<a href="{{ route('listings.show', $listing->slug) }}" class="block h-full group">
    <div class="h-full flex flex-col">
        <!-- Image Container -->
        <div class="relative pt-[75%] bg-gray-100 rounded-t-xl overflow-hidden">
            @if($listing->photos->count() > 0)
                <img 
                    src="{{ asset('storage/' . $listing->photos->first()->display_path) }}" 
                    alt="{{ $listing->title }}"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                >
            @else
                <div class="absolute inset-0 flex items-center justify-center bg-gray-100">
                    <span class="text-gray-400 text-3xl">📷</span>
                </div>
            @endif
            
            @if($listing->is_featured)
                <div class="absolute top-2 left-2 bg-rose-500 text-white text-xs font-bold px-2 py-1 rounded">
                    Unggulan
                </div>
            @endif
        </div>
        
        <!-- Content -->
        <div class="flex-1 p-4 bg-white rounded-b-xl border border-t-0 border-gray-200 group-hover:border-rose-200 transition-colors duration-200">
            <!-- Title & Price -->
            <div class="flex justify-between items-start mb-2 gap-2">
                <h3 class="font-bold text-gray-800 group-hover:text-rose-600 text-sm sm:text-base line-clamp-2 flex-1 min-w-0 transition-colors duration-200">
                    {{ $listing->title }}
                </h3>
                <div class="text-rose-600 font-bold whitespace-nowrap text-sm sm:text-base ml-2">
                    Rp {{ number_format($listing->price, 0, ',', '.') }}
                </div>
            </div>
            
            <!-- Vendor Name -->
            <p class="text-gray-600 text-xs mb-3 line-clamp-1">
                {{ $listing->vendor->business_name ?? 'Vendor' }}
            </p>
            
            <!-- Location & Views -->
            <div class="flex items-center text-gray-500 text-xs mb-4 mt-auto">
                <span class="flex items-center mr-3 truncate">
                    <span class="mr-1 flex-shrink-0">📍</span>
                    <span class="truncate">{{ $listing->location }}</span>
                </span>
                <span class="flex items-center whitespace-nowrap">
                    <span class="mr-1">👁️</span>
                    <span>{{ $listing->views_count }}</span>
                </span>
            </div>
            
            <!-- Category Badge -->
            @if($listing->category)
                <div class="inline-block px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">
                    {{ $listing->category->name }}
                </div>
            @endif
        </div>
    </div>
</a>