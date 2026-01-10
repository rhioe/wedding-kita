<div x-data="step2Uploader()" x-init="init()" class="bg-white rounded-xl shadow-sm border p-6">
    
    <!-- Toast Area -->
    <div id="toastArea-step2" class="fixed top-4 right-4 z-50 max-w-sm space-y-2"></div>

    <!-- Delete Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-96 p-6">
            <h3 class="font-bold text-lg mb-2">Hapus Foto?</h3>
            <p class="text-gray-600 mb-6">Foto akan dihapus permanen</p>
            <div class="flex gap-3">
                <button wire:click="closeDeleteModal" class="flex-1 px-4 py-2 border rounded">Batal</button>
                <button wire:click="removePhoto" class="flex-1 px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-xl font-bold text-gray-800">Foto & Galeri</h2>
            <div class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                {{ count($photos) }}/10
            </div>
        </div>
        <p class="text-gray-600">Upload 2-10 foto karya terbaik Anda</p>
    </div>

    <!-- Upload Zone -->
    <div class="mb-8">
        <input type="file" 
               id="photoInput-step2"
               wire:model="newPhotos"
               multiple 
               accept="image/*"
               class="hidden">
        
        <div onclick="document.getElementById('photoInput-step2').click()"
             class="border-3 border-dashed border-gray-300 rounded-2xl p-8 text-center cursor-pointer hover:border-green-400">
            <div class="text-5xl text-gray-300 mb-3">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Klik untuk Upload</h3>
            <p class="text-gray-500 text-sm mb-4">Auto upload langsung seperti WhatsApp</p>
            <button class="px-5 py-2 bg-green-500 text-white rounded-lg font-medium">
                <i class="fas fa-plus mr-2"></i>Pilih Foto
            </button>
        </div>

        @error('photos')
            <div class="mt-3 p-3 bg-red-50 text-red-700 rounded-lg text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <!-- Photos Grid -->
    @if(count($photos) > 0)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">
                Foto Terupload <span class="text-sm text-gray-500">({{ count($photos) }}/10)</span>
            </h3>
            <div class="text-sm text-gray-500">Klik foto untuk pilih thumbnail</div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($photos as $photo)
            <div class="relative group">
                <!-- Thumbnail Badge -->
                @if($thumbnailId == $photo['id'])
                <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full z-10 shadow-md">
                    <i class="fas fa-star mr-1"></i>Thumbnail
                </div>
                @endif

                <!-- Remove Button -->
                <button wire:click="confirmDelete('{{ $photo['id'] }}')"
                        class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <i class="fas fa-times text-sm"></i>
                </button>

                <!-- Photo Container -->
                <div data-photo-id="{{ $photo['id'] }}"
                     wire:click="setThumbnail('{{ $photo['id'] }}')"
                     class="rounded-lg overflow-hidden border-2 {{ $thumbnailId == $photo['id'] ? 'border-green-500 ring-2 ring-green-200' : 'border-gray-200' }} cursor-pointer h-40">
                    
                    <img src="{{ $photo['preview'] }}" 
                         class="w-full h-full object-cover"
                         alt="{{ $photo['name'] }}"
                         :class="{ 'blur-sm': progress['{{ $photo['id'] }}'] !== undefined }">

                    <!-- Progress Ring -->
                    <div x-show="progress['{{ $photo['id'] }}'] !== undefined" 
                         x-cloak
                         class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <div class="relative w-12 h-12">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                                <circle cx="18" cy="18" r="16" fill="none" 
                                        stroke="#3b82f6" stroke-width="3" stroke-linecap="round"
                                        :stroke-dasharray="(progress['{{ $photo['id'] }}'] || 0) + ', 100'"
                                        transform="rotate(-90 18 18)"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-white">
                                <span x-text="(progress['{{ $photo['id'] }}'] || 0) + '%'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-2">
                        <div class="text-white text-xs truncate font-medium">{{ $photo['name'] }}</div>
                        <div class="text-white/70 text-[10px]">{{ $this->formatFileSize($photo['size']) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tips -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center text-blue-800 mb-2">
            <i class="fas fa-lightbulb mr-2"></i>
            <span class="font-medium">Tips:</span>
        </div>
        <ul class="text-blue-700 text-sm space-y-1">
            <li>• Foto pertama otomatis jadi thumbnail</li>
            <li>• Klik foto lain untuk ganti thumbnail</li>
            <li>• Maksimal 10 foto</li>
            <li>• Format: JPG, PNG, WebP</li>
        </ul>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    
    .toast {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 8px;
        color: white;
        animation: slideIn 0.3s ease-out;
    }
    
    .toast-success { background: #10b981; }
    .toast-warning { background: #f59e0b; }
    .toast-error { background: #ef4444; }
    .toast-info { background: #3b82f6; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
function step2Uploader() {
    return {
        progress: {},
        uploadedPhotos: new Set(),
        
        init() {
            console.log('🚀 Step 2 Uploader Initialized');
            
            // Setup Livewire listeners
            Livewire.on('photos-added', () => {
                console.log('New photos added');
                this.startUpload();
            });
            
            Livewire.on('upload-warning', (data) => {
                this.showToast(data.message, 'warning');
            });
            
            Livewire.on('photo-deleted', (data) => {
                console.log('Photo deleted:', data.photoId);
                delete this.progress[data.photoId];
                this.uploadedPhotos.delete(data.photoId);
            });
            
            Livewire.on('thumbnail-changed', () => {
                this.showToast('Thumbnail diubah', 'success');
            });
            
            // Initial toast
            setTimeout(() => {
                this.showToast('Pilih foto untuk mulai upload', 'info');
            }, 1000);
        },
        
        startUpload() {
            this.$nextTick(() => {
                document.querySelectorAll('[data-photo-id]').forEach(el => {
                    const photoId = el.dataset.photoId;
                    
                    // Only start upload for new photos
                    if (!this.uploadedPhotos.has(photoId)) {
                        this.progress[photoId] = 0;
                        this.uploadedPhotos.add(photoId);
                        this.simulateUpload(photoId);
                    }
                });
            });
        },
        
        simulateUpload(photoId) {
            console.log('📤 Simulating upload for:', photoId);
            
            let p = 0;
            const speed = 15 + Math.random() * 20; // 15-35% per second
            
            const update = () => {
                p += speed * 0.1;
                
                if (p >= 100) {
                    p = 100;
                    this.progress[photoId] = p;
                    
                    // Remove progress after completion
                    setTimeout(() => {
                        delete this.progress[photoId];
                    }, 300);
                    
                    return;
                }
                
                this.progress[photoId] = Math.round(p);
                setTimeout(update, 100);
            };
            
            // Start with random delay for parallel feel
            setTimeout(update, Math.random() * 500);
        },
        
        showToast(message, type = 'info') {
            const area = document.getElementById('toastArea-step2');
            if (!area) return;
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle mr-2"></i>
                        <span>${message}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            area.appendChild(toast);
            
            // Auto remove
            setTimeout(() => toast.remove(), 4000);
        }
    };
}

// Drag & Drop
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('[onclick*="photoInput-step2"]');
    if (dropZone) {
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-green-500', 'bg-green-50');
        });
        
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-green-500', 'bg-green-50');
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-green-500', 'bg-green-50');
            
            const files = Array.from(e.dataTransfer.files)
                .filter(f => f.type.startsWith('image/'));
            
            if (files.length > 0) {
                const input = document.getElementById('photoInput-step2');
                const dataTransfer = new DataTransfer();
                files.forEach(f => dataTransfer.items.add(f));
                input.files = dataTransfer.files;
                input.dispatchEvent(new Event('change'));
                
                // Show toast
                const toastArea = document.getElementById('toastArea-step2');
                if (toastArea) {
                    const toast = document.createElement('div');
                    toast.className = 'toast toast-info';
                    toast.textContent = `${files.length} foto ditambahkan`;
                    toastArea.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            }
        });
    }
});
</script>
@endpush