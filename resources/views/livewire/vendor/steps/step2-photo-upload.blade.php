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
            <div class="flex items-center gap-3">
                <div class="px-3 py-1 {{ $totalUploaded >= $maxPhotos ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }} rounded-full text-sm font-medium">
                    {{ $totalUploaded }}/{{ $maxPhotos }}
                </div>
                @if($totalUploaded < 2)
                <div class="text-sm text-red-600">
                    <i class="fas fa-exclamation-circle mr-1"></i>Minimal 2 foto
                </div>
                @endif
            </div>
        </div>
        <p class="text-gray-600">Upload 2-10 foto karya terbaik Anda</p>
    </div>

    <!-- Upload Zone -->
    <div class="mb-8">
        <input type="file" 
               id="photoInput-step2"
               wire:model="uploads"
               multiple 
               accept="image/*"
               class="hidden">
        
        <div onclick="document.getElementById('photoInput-step2').click()"
             class="border-3 border-dashed border-gray-300 rounded-2xl p-8 text-center cursor-pointer hover:border-green-400 transition-colors">
            <div class="text-5xl text-gray-300 mb-3">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Klik atau Drop untuk Upload</h3>
            <p class="text-gray-500 text-sm mb-4">Auto upload langsung seperti WhatsApp</p>
            <button class="px-5 py-2 bg-green-500 text-white rounded-lg font-medium hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i>Pilih Foto
            </button>
            <p class="text-gray-400 text-xs mt-3">
                Maksimal {{ $maxPhotos }} foto • Format: JPG, PNG, WebP • Maks 5MB/foto
            </p>
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
                Foto Terupload <span class="text-sm text-gray-500">({{ $totalUploaded }}/{{ $maxPhotos }})</span>
            </h3>
            <div class="text-sm text-gray-500">Klik foto untuk pilih thumbnail</div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($photos as $photo)
            @php
                $status = $this->getPhotoStatus($photo['id']);
                $isUploading = $status['status'] === 'uploading';
                $isError = $status['status'] === 'error';
                $isDone = $status['status'] === 'done';
            @endphp
            
            <div class="relative group">
                <!-- Status Badge -->
                @if($thumbnailId == $photo['id'])
                <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full z-10 shadow-md">
                    <i class="fas fa-star mr-1"></i>Thumbnail
                </div>
                @elseif($isError)
                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full z-10 shadow-md">
                    <i class="fas fa-exclamation mr-1"></i>Error
                </div>
                @elseif($isUploading)
                <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full z-10 shadow-md">
                    <i class="fas fa-spinner fa-spin mr-1"></i>Uploading
                </div>
                @endif

                <!-- Remove Button -->
                @if($isDone)
                <button wire:click="confirmDelete('{{ $photo['id'] }}')"
                        class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 hover:bg-red-600">
                    <i class="fas fa-times text-sm"></i>
                </button>
                @endif

                <!-- Photo Container -->
                <div data-photo-id="{{ $photo['id'] }}"
                     wire:click="setThumbnail('{{ $photo['id'] }}')"
                     class="rounded-lg overflow-hidden border-2 {{ $thumbnailId == $photo['id'] ? 'border-green-500 ring-2 ring-green-200' : ($isError ? 'border-red-300' : 'border-gray-200') }} cursor-pointer h-40 relative">
                    
                    <!-- Preview Image -->
                    <img src="{{ $photo['preview'] }}" 
                         class="w-full h-full object-cover {{ $isUploading ? 'blur-sm' : '' }}"
                         alt="{{ $photo['name'] }}"
                         loading="lazy">
                    
                    <!-- Progress Overlay -->
                    @if($isUploading)
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <div class="relative w-12 h-12">
                            <!-- Progress Ring -->
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                                <circle cx="18" cy="18" r="16" fill="none" 
                                        stroke="#3b82f6" stroke-width="3" stroke-linecap="round"
                                        stroke-dasharray="{{ $status['progress'] }}, 100"
                                        transform="rotate(-90 18 18)"/>
                            </svg>
                            <!-- Progress Text -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-bold text-white">{{ $status['progress'] }}%</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Error Overlay -->
                    @if($isError)
                    <div class="absolute inset-0 bg-red-500/20 flex items-center justify-center">
                        <div class="text-center p-3">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl mb-1"></i>
                            <p class="text-xs font-medium text-red-700">{{ $status['message'] ?? 'Error' }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Photo Info -->
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

    <!-- Tips & Status -->
    <div class="space-y-4">
        <!-- Upload Status -->
        @php
            $uploadingCount = collect($photoState ?? [])->where('status', 'uploading')->count();
            $errorCount = collect($photoState ?? [])->where('status', 'error')->count();
        @endphp
        
        @if($uploadingCount > 0 || $errorCount > 0)
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="font-medium text-gray-700">Status Upload:</span>
                <div class="flex gap-3 text-sm">
                    @if($uploadingCount > 0)
                    <span class="text-blue-600">
                        <i class="fas fa-spinner fa-spin mr-1"></i>{{ $uploadingCount }} uploading
                    </span>
                    @endif
                    @if($errorCount > 0)
                    <span class="text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $errorCount }} error
                    </span>
                    @endif
                </div>
            </div>
            <div class="space-y-1">
                @foreach($photoState ?? [] as $uid => $state)
                    @if(in_array($state['status'], ['uploading', 'error']))
                    <div class="flex items-center justify-between text-xs">
                        <span class="truncate">{{ $photos[$uid]['name'] ?? 'File' }}</span>
                        <span class="{{ $state['status'] === 'error' ? 'text-red-600' : 'text-blue-600' }}">
                            {{ $state['status'] === 'uploading' ? $state['progress'].'%' : $state['message'] }}
                        </span>
                    </div>
                    @endif
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
                <li>• <strong>Accumulative upload:</strong> 3 foto + 9 foto = 12 foto (2 akan ditolak)</li>
                <li>• Foto duplikat akan ditolak dengan notifikasi</li>
                <li>• Progress ring REAL dari browser (bukan simulasi)</li>
                <li>• File kecil selesai lebih cepat</li>
                <li>• Klik "Next" hanya jika semua upload selesai</li>
            </ul>
        </div>
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
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        min-width: 300px;
        max-width: 400px;
    }
    
    .toast-success { background: linear-gradient(135deg, #10b981, #059669); }
    .toast-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .toast-error { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .toast-info { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
    
    /* Progress ring animation */
    .progress-ring-circle {
        transition: stroke-dasharray 0.3s ease;
    }
    
    /* Blur effect for uploading */
    .blur-sm {
        filter: blur(2px);
    }
</style>
@endpush

@push('scripts')
<script>
function step2Uploader() {
    return {
        init() {
            console.log('🚀 Step 2 Uploader Initialized - REAL PARALLEL UPLOAD');
            
            // Setup Livewire listeners
            this.setupLivewireListeners();
            
            // Setup drag & drop
            this.setupDragDrop();
            
            // Initial toast
            setTimeout(() => {
                this.showToast('Pilih atau drop foto untuk mulai upload', 'info');
            }, 1000);
        },
        
        setupLivewireListeners() {
            // Upload progress from Livewire
            Livewire.on('upload-progress', (data) => {
                console.log('Upload progress:', data.uid, data.progress + '%');
            });
            
            // Upload finished
            Livewire.on('upload-finished', (data) => {
                console.log('Upload finished:', data.uid);
                this.showToast('Upload selesai', 'success');
            });
            
            // Upload error
            Livewire.on('upload-error', (data) => {
                console.log('Upload error:', data.uid, data.message);
                this.showToast(`Error: ${data.message || 'Upload gagal'}`, 'error');
            });
            
            // Photo added
            Livewire.on('photo-added', (data) => {
                console.log('Photo added:', data.photo.name);
            });
            
            // Photo duplicate
            Livewire.on('photo-duplicate', (data) => {
                this.showToast(`❌ Foto "${data.filename}" sudah ada`, 'warning');
            });
            
            // Photo limit reached
            Livewire.on('photo-limit-reached', (data) => {
                const available = data.max - data.current;
                this.showToast(
                    `⚠️ Maksimal ${data.max} foto. ${available > 0 ? 
                    `Hanya ${available} foto lagi yang bisa ditambahkan.` : 
                    'Sudah mencapai batas maksimum.'}`,
                    'error'
                );
            });
            
            // Thumbnail changed
            Livewire.on('thumbnail-changed', () => {
                this.showToast('✅ Thumbnail diubah', 'success');
            });
            
            // Photo deleted
            Livewire.on('photo-deleted', () => {
                this.showToast('🗑️ Foto dihapus', 'info');
            });
            
            // Notification from Livewire
            Livewire.on('show-notification', (data) => {
                this.showToast(data.message, data.type);
            });
        },
        
        setupDragDrop() {
            const dropZone = document.querySelector('[onclick*="photoInput-step2"]');
            if (!dropZone) return;
            
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-green-500', 'bg-green-50', 'border-solid');
                dropZone.classList.remove('border-dashed', 'border-gray-300');
            });
            
            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-green-500', 'bg-green-50', 'border-solid');
                dropZone.classList.add('border-dashed', 'border-gray-300');
            });
            
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-green-500', 'bg-green-50', 'border-solid');
                dropZone.classList.add('border-dashed', 'border-gray-300');
                
                const files = Array.from(e.dataTransfer.files)
                    .filter(f => f.type.startsWith('image/'));
                
                if (files.length > 0) {
                    // Show loading state
                    this.showToast(`Memproses ${files.length} foto...`, 'info');
                    
                    // Trigger file input
                    const input = document.getElementById('photoInput-step2');
                    const dataTransfer = new DataTransfer();
                    files.forEach(f => dataTransfer.items.add(f));
                    input.files = dataTransfer.files;
                    
                    // Dispatch change event
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                    
                    // Show success message
                    setTimeout(() => {
                        this.showToast(`✅ ${files.length} foto ditambahkan ke queue upload`, 'success');
                    }, 500);
                }
            });
        },
        
        showToast(message, type = 'info') {
            const area = document.getElementById('toastArea-step2');
            if (!area) return;
            
            // Remove existing toasts if too many
            if (area.children.length > 3) {
                area.firstChild.remove();
            }
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas ${icons[type] || 'fa-info-circle'} mr-2"></i>
                        <span class="text-sm">${message}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 opacity-70 hover:opacity-100">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            `;
            
            area.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.animation = 'fadeOut 0.3s ease-out forwards';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }
    };
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize if element exists
    if (document.querySelector('[x-data="step2Uploader()"]')) {
        // Alpine will auto-init
    }
});
</script>
@endpush