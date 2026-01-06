<div>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-3 sm:py-4">
                    <div class="flex items-center">
                        <a href="{{ route('vendor.dashboard') }}" class="flex items-center text-gray-700 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-2 text-sm"></i>
                            <span class="font-medium text-sm sm:text-base">Kembali ke Dashboard</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="hidden sm:block text-right">
                            <div class="text-sm font-medium text-gray-700">{{ $vendor->name ?? 'Vendor' }}</div>
                            <div class="text-xs text-gray-500">Buat Listing Baru</div>
                        </div>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-blue-600 text-xs sm:text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Container -->
        <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
            <!-- Progress Indicator -->
            <div class="mb-6 sm:mb-10">
                <div class="flex flex-wrap items-center justify-center mb-3 sm:mb-4 space-x-1 sm:space-x-4">
                    @foreach(['Informasi Bisnis', 'Foto & Galeri', 'Paket & Harga', 'Konfirmasi'] as $index => $label)
                        @php $stepNum = $index + 1; @endphp
                        <div class="flex items-center mb-1 sm:mb-2">
                            <div class="relative">
                                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
                                    {{ $currentStep >= $stepNum ? 'bg-blue-600 text-white border-2 border-blue-600' : 'bg-white text-gray-400 border-2 border-gray-300' }}
                                    font-bold shadow-sm transition-all duration-300 text-xs sm:text-base">
                                    {{ $stepNum }}
                                </div>
                                @if($currentStep == $stepNum)
                                    <div class="absolute -bottom-2 sm:-bottom-4 left-1/2 transform -translate-x-1/2">
                                        <i class="fas fa-circle text-blue-600 text-xs animate-ping"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="ml-1 sm:ml-3">
                                <div class="text-xs sm:text-sm font-medium {{ $currentStep >= $stepNum ? 'text-blue-600' : 'text-gray-500' }}">
                                    <span class="hidden sm:inline">{{ $label }}</span>
                                    <span class="sm:hidden">S{{ $stepNum }}</span>
                                </div>
                            </div>
                            
                            @if($stepNum < 4)
                                <div class="w-3 sm:w-16 h-1 mx-1 sm:mx-4 {{ $currentStep > $stepNum ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Progress bar -->
                <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2">
                    <div class="bg-blue-600 h-1.5 sm:h-2 rounded-full transition-all duration-500"
                        style="width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>
                </div>
            </div>

            <!-- STEP 1: BUSINESS INFORMATION -->
            @if($currentStep == 1)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 overflow-hidden mb-4">
                <div class="border-b border-gray-100 px-4 sm:px-8 py-3 sm:py-6">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Informasi Bisnis</h2>
                    <p class="text-gray-600 mt-1 text-xs sm:text-base">Lengkapi informasi dasar bisnis Anda</p>
                </div>
                
                <div class="p-3 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                        <!-- Left Column -->
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Business Name -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">
                                    Nama Bisnis <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="business_name"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('business_name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                    placeholder="Contoh: Studio Foto Pernikahan Indah">
                                @error('business_name')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="category_id"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('category_id') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="location"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('location') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                    placeholder="Contoh: Jakarta Selatan, Bandung">
                                @error('location')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4 sm:space-y-6">
                            <!-- DESKRIPSI BISNIS - FIX COUNTER -->
                            <div x-data="{ charCount: {{ strlen($description ?? '') }} }">
                            <textarea 
                                wire:model="description"
                                x-ref="descTextarea"
                                x-on:input="charCount = $refs.descTextarea.value.length"
                                rows="5"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('description') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                placeholder="Jelaskan keunikan, pengalaman, dan keunggulan bisnis Anda...">
                            </textarea>
                            
                            <div class="flex justify-between mt-1 sm:mt-2">
                                <div class="text-xs sm:text-sm" 
                                    x-bind:class="charCount >= 50 ? 'text-green-600 font-medium' : 'text-gray-500'">
                                    <i x-bind:class="charCount >= 50 ? 'fas fa-check-circle' : 'fas fa-ruler'" 
                                    class="mr-1 text-xs"></i>
                                    <span x-text="charCount + '/50 karakter'"></span>
                                </div>
                                
                                @error('description')
                                    <div class="text-red-500 text-xs sm:text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                            <!-- Year Established -->
                            <div>
                                <label class="block text-gray-700 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">
                                    Tahun Berdiri <span class="text-xs sm:text-sm font-normal text-gray-500">(opsional)</span>
                                </label>
                                <input type="number" wire:model="year_established"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                    placeholder="Contoh: 2015"
                                    min="1900" max="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mt-4 sm:mt-8 pt-4 sm:pt-8 border-t border-gray-100">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-6">Kontak & Media Sosial (opsional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-6">
                            <!-- WhatsApp -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 sm:mb-2 text-sm sm:text-base">
                                    WhatsApp
                                </label>
                                <div class="flex flex-col p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fab fa-whatsapp text-green-500 text-base sm:text-lg mr-2 sm:mr-3"></i>
                                        <div class="flex-1">
                                            <span class="text-gray-700 font-medium text-sm sm:text-base">{{ $this->formattedPhone }}</span>
                                            <a href="{{ $this->whatsAppLink }}" target="_blank" 
                                            class="ml-1 sm:ml-3 text-xs sm:text-sm text-blue-600 hover:underline">
                                                <i class="fas fa-comment-medical mr-1"></i>Test Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 sm:mb-2 text-sm sm:text-base">
                                    Instagram
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-2 sm:px-3 py-2 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50 text-gray-500 text-sm">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <input type="text" wire:model="instagram"
                                        class="flex-1 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-r-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                        placeholder="username">
                                </div>
                                @error('instagram')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="mt-3 sm:mt-6">
                            <label class="block text-gray-700 font-medium mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-globe mr-1 sm:mr-2"></i>Website / Portfolio
                            </label>
                            <input type="url" wire:model="website"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                placeholder="https://contoh.com">
                            @error('website')
                                <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- STEP 2: PHOTO UPLOAD - FIXED VERSION -->
            @if($currentStep == 2)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 overflow-hidden mb-4">
                <div class="border-b border-gray-100 px-4 sm:px-8 py-3 sm:py-6">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Foto & Galeri</h2>
                    <p class="text-gray-600 mt-1 text-xs sm:text-base">Upload foto terbaik untuk menarik calon customer</p>
                </div>
                
                <div class="p-3 sm:p-6 lg:p-8">
                    <!-- ✅ FIXED: Upload Area dengan WhatsApp Loading -->
                    <div class="mb-6 sm:mb-8" x-data="{
                        uploading: @entangle('uploadingPhotos'),
                        progress: @entangle('uploadProgress'),
                        status: @entangle('uploadStatus'),
                        init() {
                            // Auto upload saat file dipilih
                            this.$watch('uploading', (value) => {
                                if (value) {
                                    console.log('Upload started...');
                                }
                            });
                        }
                    }">
                        <input type="file" id="photoUpload" wire:model="newPhotos" multiple 
                               accept="image/jpeg,image/png,image/webp" 
                               class="hidden"
                               x-on:change="$wire.uploadPhotos()">
                        
                        <label for="photoUpload" 
                               class="cursor-pointer block border-2 border-dashed border-gray-300 rounded-lg sm:rounded-2xl p-4 sm:p-8 text-center hover:border-green-400 hover:bg-green-50 transition-all duration-300 relative"
                               :class="{ 'opacity-70 pointer-events-none': uploading }">
                            
                            <!-- WhatsApp Loading Overlay -->
                            <div x-show="uploading" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute inset-0 bg-white/90 backdrop-blur-sm rounded-lg sm:rounded-2xl flex flex-col items-center justify-center z-20">
                                
                                <!-- WhatsApp Spinner -->
                                <div class="relative w-20 h-20 mb-4">
                                    <div class="whatsapp-spinner"></div>
                                    <!-- Percentage -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-green-600 font-bold text-lg" x-text="progress + '%'"></span>
                                    </div>
                                </div>
                                
                                <!-- Status Text -->
                                <p class="text-green-700 font-semibold text-center mb-2" x-text="status"></p>
                                <p class="text-gray-600 text-sm">Otomatis kompres ke 1MB</p>
                                
                                <!-- Progress Bar -->
                                <div class="w-48 mt-4">
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all duration-300"
                                             :style="'width: ' + progress + '%'"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Upload Icon -->
                            <div class="text-4xl sm:text-5xl mb-3 sm:mb-4 text-gray-400">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-base sm:text-xl font-semibold text-gray-700 mb-1 sm:mb-2">
                                
                                Upload Foto
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-500 mb-3 sm:mb-4 text-xs sm:text-base">
                                Drag & drop atau klik untuk memilih
                            </p>
                            
                            <!-- Button -->
                            <div class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg font-medium hover:from-green-600 hover:to-green-700 transition-all shadow-sm">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                Pilih Foto
                            </div>
                            
                            <!-- Info -->
                            <div class="mt-3 sm:mt-4 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Maks 20 foto • Auto compress ke ~1MB • Format: JPG, PNG, WebP
                            </div>
                        </label>
                        
                        <!-- Real-time Feedback -->
                        <div x-show="uploading" x-transition class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center text-green-700">
                                <i class="fas fa-sync-alt animate-spin mr-2"></i>
                                <span class="text-sm font-medium">Sedang mengupload...</span>
                            </div>
                            <p class="text-green-600 text-xs mt-1" x-text="status"></p>
                        </div>
                    </div>

                    <!-- Photo Gallery -->
                    @if(count($photos) > 0)
                    <div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-3 sm:mb-6">
                            <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-1 sm:mb-0">
                                <i class="fas fa-images mr-1 sm:mr-2"></i>
                                Foto Terupload <span class="text-blue-600">({{ count($photos) }}/20)</span>
                            </h3>
                            <div class="text-xs text-gray-500 mt-1 sm:mt-0">
                                <i class="fas fa-mouse-pointer mr-1"></i>
                                Klik foto untuk pilih Thumbnail
                            </div>
                        </div>

                        <!-- Photo Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 sm:gap-4">
                            @foreach($photos as $index => $photo)
                            <div class="relative group photo-preview" wire:key="photo-{{ $index }}-{{ $loop->index }}">
                                <div class="relative overflow-hidden rounded-md sm:rounded-xl border-2 {{ $thumbnailIndex == $index ? 'border-blue-500 ring-1 sm:ring-2 ring-blue-200' : 'border-gray-200' }} cursor-pointer"
                                    wire:click="$set('thumbnailIndex', {{ $index }})">
                                    
                                    <img src="{{ $photo->temporaryUrl() }}" 
                                        class="w-full h-28 sm:h-40 object-cover transition-transform duration-300 group-hover:scale-105">
                                    
                                    @if($thumbnailIndex == $index)
                                    <div class="absolute top-1 sm:top-2 left-1 sm:left-2 bg-blue-600 text-white text-xs px-1 sm:px-2 py-0.5 sm:py-1 rounded-full flex items-center">
                                        <i class="fas fa-star text-xs mr-0.5 sm:mr-1"></i>
                                        <span class="hidden sm:inline">Thumbnail</span>
                                    </div>
                                    @endif
                                    
                                    <!-- Remove Button -->
                                    <button wire:click="removePhoto({{ $index }})"
                                            x-on:click.stop
                                            class="absolute top-1 sm:top-2 right-1 sm:right-2 bg-red-500 text-white w-5 h-5 sm:w-8 sm:h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:bg-red-600 text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-1 sm:p-3 text-white">
                                        <div class="text-xs truncate">
                                            <i class="fas fa-file-image mr-0.5 sm:mr-1"></i>
                                            <span class="text-xxs sm:text-xs">{{ Str::limit($photo->getClientOriginalName(), 15) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Upload Tips -->
                        <div class="mt-4 sm:mt-10 p-3 sm:p-6 bg-blue-50 border border-blue-200 rounded-lg sm:rounded-xl">
                            <div class="flex items-center text-blue-800 mb-1 sm:mb-3">
                                <i class="fas fa-lightbulb mr-1 sm:mr-2"></i>
                                <span class="font-semibold text-xs sm:text-base">Tips Upload Foto:</span>
                            </div>
                            <ul class="space-y-1 sm:space-y-2 text-blue-700 text-xs sm:text-sm">
                                <li class="flex items-start">
                                    <i class="fas fa-check mt-0.5 mr-1 sm:mr-2 text-blue-600 text-xs"></i>
                                    <span>Pilih foto terbaik sebagai thumbnail</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mt-0.5 mr-1 sm:mr-2 text-blue-600 text-xs"></i>
                                    <span>Gunakan foto dengan resolusi tinggi</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mt-0.5 mr-1 sm:mr-2 text-blue-600 text-xs"></i>
                                    <span>Variasi foto: eksterior, interior, karya terbaik</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-6 sm:py-12">
                        <div class="text-4xl sm:text-6xl mb-2 sm:mb-4 text-gray-300">
                            <i class="fas fa-images"></i>
                        </div>
                        <h3 class="text-base sm:text-xl font-medium text-gray-700 mb-1 sm:mb-2">Belum ada foto</h3>
                        <p class="text-gray-500 max-w-md mx-auto text-xs sm:text-base px-2">
                            Upload minimal 1 foto untuk melanjutkan.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- STEP 3: PACKAGE & PRICING -->
            @if($currentStep == 3)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 overflow-hidden mb-4">
                <div class="border-b border-gray-100 px-4 sm:px-8 py-3 sm:py-6">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Paket & Harga</h2>
                    <p class="text-gray-600 mt-1 text-xs sm:text-base">Tentukan paket layanan dan harga</p>
                </div>
                
                <div class="p-3 sm:p-6 lg:p-8">
                    <div class="space-y-4 sm:space-y-8">
                        <!-- Package Name -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1 sm:mb-3 text-sm sm:text-base">
                                <i class="fas fa-box mr-1 sm:mr-2"></i>Nama Paket <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="package_name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('package_name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                placeholder="Contoh: Paket Basic, Paket Premium">
                            @error('package_name')
                                <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- HARGA PAKET - FIX FORMAT DENGAN TITIK -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1 sm:mb-3 text-sm sm:text-base">
                                <i class="fas fa-tag mr-1 sm:mr-2"></i>Harga Paket <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative max-w-md">
                                <span class="absolute left-3 sm:left-4 top-2 sm:top-3 text-gray-500 font-medium text-sm sm:text-base">Rp</span>
                                
                                <input type="text" 
                                    wire:model.live="price_input"
                                    class="w-full pl-8 sm:pl-12 pr-10 sm:pr-12 py-2 sm:py-3 border {{ $errors->has('price') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                    placeholder="0"
                                    inputmode="numeric">
                                    
                                <div class="absolute right-3 sm:right-4 top-2 sm:top-3 text-gray-500 text-sm sm:text-base">,00</div>
                            </div>
                            
                            <div class="mt-1">
                                @error('price')
                                    <div class="text-red-500 text-xs sm:text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Package Description -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1 sm:mb-3 text-sm sm:text-base">
                                <i class="fas fa-align-left mr-1 sm:mr-2"></i>Deskripsi Paket
                                <span class="text-xs sm:text-sm font-normal text-gray-500">(opsional)</span>
                            </label>
                            <textarea wire:model="package_description" rows="3"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                    placeholder="Tuliskan detail paket Anda... (opsional)"></textarea>
                        </div>

                        <!-- Validity Period -->
                        <div class="max-w-md">
                            <label class="block text-gray-700 font-semibold mb-1 sm:mb-3 text-sm sm:text-base">
                                <i class="fas fa-calendar-alt mr-1 sm:mr-2"></i>Masa Berlaku Paket
                            </label>
                            <input type="text" wire:model="validity_period"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                placeholder="Contoh: 6 bulan">
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="mt-4 sm:mt-10 p-3 sm:p-6 bg-yellow-50 border border-yellow-200 rounded-lg sm:rounded-xl">
                            <div class="flex items-start">
                                <input type="checkbox" id="terms" wire:model="terms_accepted"
                                    class="mt-0.5 sm:mt-1 mr-2 sm:mr-3 w-4 h-4 sm:w-5 sm:h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="terms" class="text-gray-700 text-xs sm:text-sm">
                                    <i class="fas fa-file-contract mr-1"></i>
                                    <span class="font-semibold">Syarat & Ketentuan:</span> Saya menyetujui bahwa listing ini akan ditinjau oleh admin sebelum tampil di marketplace.
                                </label>
                            </div>
                            @error('terms_accepted')
                                <div class="mt-1 sm:mt-2 text-red-500 text-xs sm:text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- STEP 4: CONFIRMATION PAGE -->
            @if($currentStep == 4)
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 overflow-hidden mb-4">
                <div class="border-b border-gray-100 px-4 sm:px-8 py-3 sm:py-6 bg-gradient-to-r from-green-50 to-blue-50">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-check text-green-600 mr-1 sm:mr-3 text-sm sm:text-base"></i>
                        Konfirmasi Listing
                    </h2>
                    <p class="text-gray-600 mt-1 text-xs sm:text-base">Tinjau kembali data sebelum dikirim</p>
                </div>
                
                <div class="p-3 sm:p-6 lg:p-8">
                    <!-- Business Info Summary -->
                    <div class="mb-4 sm:mb-10">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-6 flex items-center">
                            <i class="fas fa-store text-wedding-purple mr-1 sm:mr-2 text-sm"></i>
                            Informasi Bisnis
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-6">
                            <div class="space-y-2 sm:space-y-4">
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Nama Bisnis</label>
                                    <p class="font-medium text-sm sm:text-base">{{ $business_name }}</p>
                                </div>
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Kategori</label>
                                    <p class="font-medium text-sm sm:text-base">
                                        @foreach($this->categories as $cat)
                                            @if($cat->id == $category_id) {{ $cat->name }} @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Lokasi</label>
                                    <p class="font-medium text-sm sm:text-base">{{ $location }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 sm:space-y-4">
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Tahun Berdiri</label>
                                    <p class="font-medium text-sm sm:text-base">{{ $year_established ?: '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Instagram</label>
                                    <p class="font-medium text-sm sm:text-base">{{ $instagram ? '@'.$instagram : '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs sm:text-sm text-gray-500">Website</label>
                                    <p class="font-medium text-sm sm:text-base">{{ $website ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 sm:mt-6">
                            <label class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 block">Deskripsi</label>
                            <p class="text-gray-700 bg-gray-50 p-2 sm:p-4 rounded-lg text-xs sm:text-base leading-relaxed">{{ $description }}</p>
                        </div>
                    </div>

                    <!-- Photo Preview -->
                    <div class="mb-4 sm:mb-10">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-6 flex items-center">
                            <i class="fas fa-images text-blue-600 mr-1 sm:mr-2 text-sm"></i>
                            Foto & Galeri
                        </h3>
                        <div class="mb-2 sm:mb-4">
                            <p class="font-medium text-sm sm:text-base">{{ count($photos) }} foto terupload</p>
                            <p class="text-xs text-gray-500 mt-1">Thumbnail dipilih: foto ke-{{ $thumbnailIndex + 1 }}</p>
                        </div>
                        
                        @if(count($photos) > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-1 sm:gap-3">
                            @foreach($photos as $index => $photo)
                            <div class="relative">
                                <img src="{{ $photo->temporaryUrl() }}" 
                                    class="w-full h-16 sm:h-24 md:h-28 object-cover rounded border-2 {{ $thumbnailIndex == $index ? 'border-blue-500' : 'border-gray-200' }}">
                                @if($thumbnailIndex == $index)
                                <div class="absolute top-0.5 left-0.5 bg-blue-600 text-white text-xxs sm:text-xs px-1 py-0.5 rounded-full">
                                    <i class="fas fa-star"></i>
                                </div>
                                @endif
                                <div class="absolute bottom-0.5 right-0.5 bg-black/70 text-white text-xxs sm:text-xs px-1 py-0.5 rounded">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Package Summary -->
                    <div class="mb-4 sm:mb-10">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-6 flex items-center">
                            <i class="fas fa-gift text-purple-600 mr-1 sm:mr-2 text-sm"></i>
                            Paket & Harga
                        </h3>
                        <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-3 sm:p-6 rounded-lg sm:rounded-xl">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 sm:mb-4">
                                <div class="mb-2 sm:mb-0">
                                    <h4 class="text-base sm:text-xl font-bold text-gray-800">{{ $package_name }}</h4>
                                    <div class="text-lg sm:text-2xl font-bold text-wedding-purple mt-1 sm:mt-2">
                                        Rp {{ $this->formattedPrice }}
                                    </div>
                                </div>
                                @if($validity_period)
                                <div class="bg-white px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm mt-1 sm:mt-0">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $validity_period }}
                                </div>
                                @endif
                            </div>
                            @if($package_description)
                            <div class="mt-2 sm:mt-4">
                                <label class="text-xs sm:text-sm text-gray-500 mb-1 sm:mb-2 block">Deskripsi Paket</label>
                                <p class="text-gray-700 whitespace-pre-line text-xs sm:text-base">{{ $package_description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- WhatsApp Contact -->
                    <div class="mb-4 sm:mb-10 p-3 sm:p-6 bg-green-50 border border-green-200 rounded-lg sm:rounded-xl">
                        <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-2 sm:mb-4 flex items-center">
                            <i class="fab fa-whatsapp text-green-600 mr-1 sm:mr-2 text-sm"></i>
                            Kontak WhatsApp
                        </h3>
                        <div class="flex items-center">
                            <div class="text-xl sm:text-3xl mr-2 sm:mr-4">📱</div>
                            <div>
                                <p class="font-medium text-sm sm:text-base">{{ $this->formattedPhone }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 sm:mt-1">
                                    Customer akan menghubungi Anda via nomor ini
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Final Note -->
                    <div class="p-3 sm:p-6 bg-yellow-50 border border-yellow-200 rounded-lg sm:rounded-xl">
                        <div class="flex">
                            <i class="fas fa-info-circle text-yellow-600 text-base sm:text-xl mr-2 mt-0.5"></i>
                            <div>
                                <p class="font-medium text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">Proses Selanjutnya</p>
                                <ul class="text-gray-600 space-y-0.5 sm:space-y-1 text-xs sm:text-sm">
                                    <li><i class="fas fa-check-circle text-green-500 mr-1 sm:mr-2 text-xs"></i>Listing akan ditinjau oleh admin</li>
                                    <li><i class="fas fa-bell text-blue-500 mr-1 sm:mr-2 text-xs"></i>Anda akan mendapat notifikasi WhatsApp</li>
                                    <li><i class="fas fa-store text-purple-500 mr-1 sm:mr-2 text-xs"></i>Listing akan muncul di homepage</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- ✅ FIXED: NAVIGATION BUTTONS - ALWAYS VISIBLE -->
            <div class="mt-6 sm:mt-8 pt-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="w-full sm:w-auto order-2 sm:order-1">
                        @if($currentStep > 1)
                            <button wire:click="previousStep"
                                    wire:loading.attr="disabled"
                                    class="flex items-center justify-center w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </button>
                        @else
                            <!-- Placeholder untuk alignment -->
                            <div class="w-full sm:w-auto h-10 sm:h-12"></div>
                        @endif
                    </div>

                    <div class="w-full sm:w-auto order-1 sm:order-2">
                        @if($currentStep < 3)
                            <button type="button" wire:click="nextStep"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    class="flex items-center justify-center w-full sm:w-auto px-4 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition font-medium shadow-sm text-sm">
                                Lanjut ke Step {{ $currentStep + 1 }}
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        @elseif($currentStep == 3)
                            <button type="button" wire:click="nextStep"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    class="flex items-center justify-center w-full sm:w-auto px-4 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition font-medium shadow-sm text-sm">
                                <i class="fas fa-clipboard-check mr-2"></i>
                                Tinjau & Konfirmasi
                            </button>
                        @elseif($currentStep == 4)
                            <button wire:click="submit"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    wire:target="submit"
                                    class="flex items-center justify-center w-full sm:w-auto px-4 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg transition font-medium shadow-sm text-sm">
                                <span wire:loading.remove>
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Kirim untuk Review
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Processing...
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Progress Footer -->
                <div class="mt-4 text-center sm:text-left">
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-steps mr-1"></i>
                        Step {{ $currentStep }} dari 4 • 
                        <span class="font-medium text-blue-600">{{ round((($currentStep - 1) / 3) * 100) }}% selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Animation CSS -->
    <style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .text-xxs {
        font-size: 0.65rem;
    }
    
    /* WhatsApp Spinner */
    .whatsapp-spinner {
        width: 80px;
        height: 80px;
        border: 4px solid rgba(37, 211, 102, 0.2);
        border-top: 4px solid #25D366;
        border-radius: 50%;
        animation: spin-whatsapp 1s linear infinite;
        position: relative;
    }

    .whatsapp-spinner::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border: 4px solid rgba(37, 211, 102, 0.1);
        border-radius: 50%;
    }

    @keyframes spin-whatsapp {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Photo Preview Animation */
    .photo-preview {
        animation: photoAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes photoAppear {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* WhatsApp Toast */
    .whatsapp-toast {
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        border-radius: 12px;
        padding: 14px 18px;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid #25D366;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Ensure buttons are always visible */
    @media (max-width: 640px) {
        .min-h-screen {
            padding-bottom: 80px;
        }
    }
    </style>

    <!-- JavaScript untuk Real-time Feedback -->
    <script>
    document.addEventListener('livewire:initialized', () => {
        
        
        // WhatsApp Style Toast Notification
        Livewire.on('toast-message', (event) => {
            const toast = document.createElement('div');
            toast.className = event.type === 'success' ? 'whatsapp-toast' :
                             event.type === 'warning' ? 'bg-yellow-500 text-white p-4 rounded-lg shadow-lg' :
                             event.type === 'error' ? 'bg-red-500 text-white p-4 rounded-lg shadow-lg' :
                             'bg-blue-500 text-white p-4 rounded-lg shadow-lg';
            
            toast.innerHTML = `
                <div class="flex items-center">
                    ${event.type === 'success' ? '<i class="fab fa-whatsapp text-xl mr-3"></i>' : 
                      event.type === 'warning' ? '<i class="fas fa-exclamation-triangle mr-3"></i>' :
                      event.type === 'error' ? '<i class="fas fa-times-circle mr-3"></i>' :
                      '<i class="fas fa-info-circle mr-3"></i>'}
                    <div>
                        <p class="font-semibold">${event.message}</p>
                        <p class="text-xs opacity-90 mt-1">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                    </div>
                </div>
            `;
            
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                max-width: 400px;
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.style.animation = 'slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1) reverse';
                setTimeout(() => toast.remove(), 400);
            }, 5000);
        });
        
        // Highlight new photo when added
        Livewire.on('photo-added', () => {
            setTimeout(() => {
                const photos = document.querySelectorAll('.photo-preview');
                if (photos.length > 0) {
                    const lastPhoto = photos[photos.length - 1];
                    lastPhoto.classList.add('photo-preview');
                }
            }, 100);
        });
    });
    </script>
</div>