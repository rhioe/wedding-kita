{{-- resources\views\livewire\vendor\steps\step2-photo-upload.blade.php --}}

<div class="min-h-screen bg-gray-50 p-4" x-data="{ showToast: @entangle('showToast'), toastType: @entangle('toastType') }">
    <!-- Toast Notification -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div :class="{
            'bg-green-50 border-green-200 text-green-800': toastType === 'success',
            'bg-red-50 border-red-200 text-red-800': toastType === 'error',
            'bg-yellow-50 border-yellow-200 text-yellow-800': toastType === 'warning',
            'bg-blue-50 border-blue-200 text-blue-800': toastType === 'info'
        }" class="border rounded-lg p-4 shadow-lg">
            <div class="flex items-center gap-3">
                <i :class="{
                    'fas fa-check-circle text-green-600': toastType === 'success',
                    'fas fa-exclamation-circle text-red-600': toastType === 'error',
                    'fas fa-exclamation-triangle text-yellow-600': toastType === 'warning',
                    'fas fa-info-circle text-blue-600': toastType === 'info'
                }" class="text-lg"></i>
                <div class="flex-1">
                    <p class="font-medium">{{ $toastMessage }}</p>
                </div>
                <button @click="showToast = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Step Header -->
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Upload Foto</h2>
            <p class="text-gray-600 mt-2">Upload minimal 2, maksimal 10 foto. Pilih 1 sebagai thumbnail.</p>
            
            <div class="flex items-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-700">
                        {{ count($photos) }}/10 foto
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full {{ $thumbnailId ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                    <span class="text-sm text-gray-700">
                        Thumbnail: {{ $thumbnailId ? '✓' : '✗' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Upload Zone -->
        <div class="mb-8">
            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center 
                       hover:border-blue-400 hover:bg-blue-50 transition-colors cursor-pointer"
                 onclick="document.getElementById('photoInput').click()">
                <div class="max-w-sm mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-cloud-upload-alt text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Klik atau drop foto</h3>
                    <p class="text-sm text-gray-600 mb-4">Format: JPG, PNG, WebP • Maks 10MB</p>
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Pilih File
                    </button>
                </div>
                <input type="file" id="photoInput" wire:model="newPhotos" multiple 
                       accept="image/*" class="hidden">
            </div>
        </div>

        <!-- Photo Grid -->
        @if(count($photos) > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Foto Terupload</h3>
                <span class="text-sm text-gray-600">
                    Klik tombol "Pilih" di bawah foto untuk jadikan thumbnail
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($photos as $photo)
                @php
                    $isThumbnail = $thumbnailId === $photo['id'];
                    $progress = $uploadProgress[$photo['id']] ?? 100;
                    $isUploading = $progress < 100;
                @endphp
                
                <div class="relative group" wire:key="{{ $photo['id'] }}">
                    <!-- Photo Card -->
                    <div class="relative overflow-hidden rounded-lg border-2 
                                {{ $isThumbnail ? 'border-blue-500 border-3' : 'border-gray-200' }}
                                bg-white transition-all hover:shadow-lg">
                        
                        <!-- Image with Progress -->
                        <div class="aspect-square relative">
                            <!-- Progress Overlay -->
                            @if($isUploading)
                            <div class="absolute inset-0 bg-white/90 flex items-center justify-center z-10">
                                <div class="text-center">
                                    <!-- Progress Ring -->
                                    <div class="relative w-16 h-16 mx-auto mb-2">
                                        <svg class="w-full h-full" viewBox="0 0 100 100">
                                            <circle cx="50" cy="50" r="40" stroke="#e5e7eb" 
                                                    stroke-width="8" fill="none"/>
                                            <circle cx="50" cy="50" r="40" stroke="#3b82f6" 
                                                    stroke-width="8" fill="none" stroke-linecap="round"
                                                    stroke-dasharray="251.2"
                                                    :stroke-dashoffset="251.2 * (1 - {{ $progress }}/100)"
                                                    class="transition-all duration-300"
                                                    transform="rotate(-90 50 50)"/>
                                        </svg>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-600">
                                                {{ $progress }}%
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-600">Uploading...</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Actual Image -->
                            <img src="{{ $photo['preview'] }}" 
                                 alt="{{ $photo['name'] }}"
                                 class="w-full h-full object-cover {{ $isUploading ? 'opacity-50' : '' }}"
                                 @if($isUploading)
                                    x-init="setTimeout(() => {
                                        Livewire.dispatch('upload-progress', {photoId: '{{ $photo['id'] }}', progress: 100});
                                    }, 1000)"
                                 @endif>
                            
                            <!-- Delete Button (Top Right) -->
                            <button wire:click="confirmDelete('{{ $photo['id'] }}')"
                                    class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white 
                                           rounded-full flex items-center justify-center 
                                           opacity-0 group-hover:opacity-100 transition-opacity
                                           hover:bg-red-600">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                            
                            <!-- Thumbnail Badge (Top Left) -->
                            @if($isThumbnail)
                            <div class="absolute top-2 left-2 bg-blue-500 text-white 
                                        text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-star mr-1"></i> Thumbnail
                            </div>
                            @endif
                        </div>
                        
                        <!-- Thumbnail Selector Button (Bawah Foto) -->
                        <div class="p-3 text-center">
                            <button wire:click="setThumbnail('{{ $photo['id'] }}')"
                                    class="w-full py-2 text-sm rounded-lg font-medium
                                           {{ $isThumbnail 
                                              ? 'bg-blue-100 text-blue-700 border border-blue-300' 
                                              : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                @if($isThumbnail)
                                    <i class="fas fa-check mr-2"></i> Thumbnail Dipilih
                                @else
                                    Pilih sebagai Thumbnail
                                @endif
                            </button>
                        </div>
                    </div>
                    
                    <!-- File Info -->
                    <div class="mt-2 text-xs text-gray-600 text-center">
                        <div class="truncate">{{ $photo['name'] }}</div>
                        <div>{{ round($photo['size'] / 1024) }} KB</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto mb-4 text-gray-300">
                <i class="fas fa-images text-5xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada foto</h3>
            <p class="text-gray-500">Upload minimal 2 foto untuk melanjutkan</p>
        </div>
        @endif

        <!-- Delete Modal -->
        @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-red-100 
                                flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Foto?</h3>
                    <p class="text-gray-600 mb-6">
                        Foto akan dihapus. Anda perlu minimal 2 foto untuk melanjutkan.
                    </p>
                    
                    <div class="flex gap-3">
                        <button wire:click="closeDeleteModal"
                                class="flex-1 py-2.5 border border-gray-300 rounded-lg 
                                       hover:bg-gray-50 transition-colors font-medium">
                            Batal
                        </button>
                        <button wire:click="removePhoto"
                                class="flex-1 py-2.5 bg-red-500 text-white rounded-lg 
                                       hover:bg-red-600 transition-colors font-medium">
                            Hapus Foto
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Script untuk auto-hide toast -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide toast
            Livewire.on('hide-toast', () => {
                setTimeout(() => {
                    @this.set('showToast', false);
                }, 3000);
            });
            
            // Handle upload complete
            window.addEventListener('upload-complete', (e) => {
                const photoId = e.detail.photoId;
                const progressElement = document.querySelector(`[wire\\:key="${photoId}"] .progress-ring`);
                if (progressElement) {
                    setTimeout(() => {
                        progressElement.closest('.absolute').style.opacity = '0';
                        setTimeout(() => {
                            progressElement.closest('.absolute').remove();
                        }, 300);
                    }, 500);
                }
            });
        });
    </script>
</div>