{{-- resources\views\livewire\vendor\steps\step4-review-submit.blade.php --}}

<div class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-4xl mx-auto">
        <!-- Step Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Review & Kirim Listing</h2>
            <p class="text-gray-600 mt-2">Periksa kembali data Anda sebelum mengirim</p>
        </div>
        
        <!-- Review Sections -->
        <div class="space-y-6">
            <!-- Section 1: Informasi Bisnis -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">1. Informasi Bisnis</h3>
                    <button wire:click="$dispatch('goToStep', [1])"
                            class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Bisnis</p>
                        <p class="font-medium">{{ $listingData['business_name'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="font-medium">{{ $this->getCategoryName($listingData['category_id'] ?? '') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Lokasi</p>
                        <p class="font-medium">{{ $listingData['location'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tahun Berdiri</p>
                        <p class="font-medium">{{ $listingData['year_established'] ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Deskripsi Bisnis</p>
                    <p class="mt-1">{{ $listingData['description'] ?? '-' }}</p>
                </div>
                
                @if($listingData['instagram'] ?? false)
                <div class="mt-3">
                    <p class="text-sm text-gray-500">Instagram</p>
                    <p class="font-medium">{{ $listingData['instagram'] }}</p>
                </div>
                @endif
                
                @if($listingData['website'] ?? false)
                <div class="mt-3">
                    <p class="text-sm text-gray-500">Website</p>
                    <p class="font-medium">{{ $listingData['website'] }}</p>
                </div>
                @endif
            </div>
            
            <!-- Section 2: Foto Portfolio -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">2. Foto Portfolio</h3>
                    <button wire:click="$dispatch('goToStep', [2])"
                            class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>

                    
                </div>
                
                @if(!empty($photoPreviews))
                <div class="mb-4">
                    <p class="text-sm text-gray-500">
                        Total Foto: {{ count($photoPreviews) }} 
                        | Thumbnail: 
                        <span class="text-green-600 font-medium">
                            @foreach($photoPreviews as $photo)
                                @if($photo['id'] === ($listingData['thumbnail_id'] ?? ''))
                                    Foto #{{ $loop->iteration }}
                                @endif
                            @endforeach
                        </span>
                    </p>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($photoPreviews as $photo)
                    <div class="relative">
                        <div class="aspect-square rounded-lg overflow-hidden border {{ $photo['id'] === ($listingData['thumbnail_id'] ?? '') ? 'border-blue-500 border-2' : 'border-gray-200' }}">
                            <img src="{{ $photo['preview'] ?? '' }}" 
                                 alt="Foto {{ $loop->iteration }}"
                                 class="w-full h-full object-cover">
                        </div>
                        @if($photo['id'] === ($listingData['thumbnail_id'] ?? ''))
                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-star mr-1"></i> Thumbnail
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-images text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada foto yang diupload</p>
                </div>
                @endif
            </div>
            
                       
            {{-- 3. Detail Paket & Harga --}}
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-lg font-semibold">3. Detail Paket & Harga</h3>
                    <button wire:click="$dispatch('goToStep', [3])"
                            class="text-blue-600 hover:underline text-sm">
                        Edit
                    </button>
                </div>

                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Nama Paket:</strong> {{ $listingData['package_name'] }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($listingData['price'], 0, ',', '.') }}</p>
                    <p><strong>Deskripsi Paket:</strong> {{ $listingData['package_description'] }}</p>
                    <p><strong>Masa Berlaku:</strong> {{ $listingData['validity_period'] ?: '-' }}</p>
                </div>
            </div>

                    
            <!-- Submit Section -->
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kirim Listing</h3>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm text-yellow-800">
                                <span class="font-semibold">Perhatian:</span> 
                                Listing Anda akan ditinjau oleh admin terlebih dahulu. 
                                Proses approval membutuhkan waktu 1-2 hari kerja.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button wire:click="submitListing"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg 
                                   hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span wire:loading.remove>Kirim untuk Review</span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...
                        </span>
                    </button>
                </div>
                
                <!-- Loading Indicator -->
                @if($isSubmitting)
                <div class="mt-4 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="ml-3 text-gray-600">Menyimpan data...</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Auto-hide flash messages
document.addEventListener('DOMContentLoaded', function() {
    // Jika ada flash message, auto-hide setelah 5 detik
    const flashMessages = document.querySelectorAll('[x-show]');
    flashMessages.forEach(msg => {
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }, 5000);
    });
});
</script>