<div class="min-h-screen bg-gray-50">
    <!-- Scroll to top trigger -->
    <div x-data="{ scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); } }" 
         x-init="Livewire.on('scroll-to-top', () => scrollToTop())"></div>
    
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
                        <div class="text-sm font-medium text-gray-700">{{ auth()->user()->vendor->business_name ?? 'Vendor' }}</div>
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
                        <!-- Description -->
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
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- STEP 2: PHOTO UPLOAD -->
        @if($currentStep == 2)
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md border border-gray-100 overflow-hidden mb-4"
            x-data="photoUploadApp()"
            x-init="init()">
            
            <div class="border-b border-gray-100 px-4 sm:px-8 py-3 sm:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Foto & Galeri</h2>
                    <div class="flex items-center gap-3">
                        <!-- Counter -->
                        <div class="counter-badge">
                            (<span id="photoCounter">{{ count($photos) }}</span>/10)
                        </div>
                        <!-- Error Message -->
                        <div id="errorMessage" class="error-message hidden">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span id="errorText"></span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 mt-1 text-xs sm:text-base">Upload 2-10 foto karya terbaik Anda</p>
            </div>
            
            <div class="p-3 sm:p-6 lg:p-8">
                <!-- Stats -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-images text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">
                                    <span class="text-blue-600">{{ count($photos) }}</span> / 10 foto
                                </div>
                                <div class="text-sm text-gray-600">
                                    @if(count($photos) >= 2)
                                    <span class="text-green-600">✓ Minimal terpenuhi</span>
                                    @else
                                    Butuh {{ 2 - count($photos) }} foto lagi
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Upload Status -->
                        <div class="text-sm px-3 py-2 rounded-lg bg-gray-100 text-gray-700">
                            <i class="fas fa-sync-alt animate-spin mr-2 hidden" id="uploadSpinner"></i>
                            <span id="statusText">Ready</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Zone -->
                <div class="mb-8">
                    <!-- Hidden File Input for Livewire -->
                    <input type="file" 
                        id="livewirePhotoInput" 
                        wire:model="photos" 
                        multiple 
                        accept="image/jpeg,image/png,image/webp" 
                        class="hidden">
                    
                    <!-- Visual Upload Zone -->
                    <div class="border-3 border-dashed border-gray-300 rounded-2xl p-6 sm:p-10 text-center transition-all duration-300 hover:border-green-400 hover:bg-green-50 min-h-[250px] flex flex-col items-center justify-center cursor-pointer"
                        onclick="document.getElementById('livewirePhotoInput').click()"
                        id="dropZone">
                        
                        <!-- Default State -->
                        <div class="w-full" id="uploadZoneContent">
                            <!-- Icon -->
                            <div class="text-6xl sm:text-7xl mb-4 text-gray-200">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-2">
                                Upload Foto
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                                Drag & drop atau klik untuk memilih foto
                                <br><span class="text-sm">Auto upload langsung!</span>
                            </p>
                            
                            <!-- Upload Button -->
                            <div class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-bold shadow-lg cursor-pointer text-lg">
                                <i class="fas fa-cloud-upload-alt mr-3 text-xl"></i>
                                Pilih Foto
                            </div>
                            
                            <!-- Info -->
                            <div class="mt-6 text-sm text-gray-500">
                                <div class="flex flex-wrap justify-center gap-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        Auto upload parallel
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-images mr-2"></i>
                                        Maks 10 foto
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-mobile-alt mr-2"></i>
                                        Mobile optimized
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Photos Gallery -->
                @if(count($photos) > 0)
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Foto Terupload
                        </h3>
                        <div class="text-sm text-gray-500">
                            Klik foto untuk pilih thumbnail
                        </div>
                    </div>
                    
                    <!-- Photos Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3" id="photosGrid">
                        @foreach($photos as $index => $photo)
                        <div class="relative group" wire:key="photo-{{ $index }}">
                            <div class="relative overflow-hidden rounded-lg border-2 {{ $index == $thumbnailIndex ? 'border-green-500 ring-1 ring-green-200' : 'border-gray-200' }} cursor-pointer"
                                wire:click="setThumbnail({{ $index }})">
                                
                                <!-- Photo Preview -->
                                @if(method_exists($photo, 'temporaryUrl'))
                                    <img src="{{ $photo->temporaryUrl() }}" 
                                        class="w-full h-40 object-cover transition-transform duration-300 group-hover:scale-105"
                                        alt="{{ $photo->getClientOriginalName() }}">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Thumbnail Badge -->
                                @if($index == $thumbnailIndex)
                                <div class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full flex items-center z-10">
                                    <i class="fas fa-star text-xs mr-1"></i>
                                    <span class="hidden sm:inline">Thumbnail</span>
                                </div>
                                @endif
                                
                                <!-- Remove Button (Mobile Always Visible) -->
                                <button wire:click="removePhoto({{ $index }})"
                                        onclick="event.stopPropagation();"
                                        class="remove-btn absolute top-2 right-2 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition-all duration-200"
                                        title="Hapus foto">
                                    <i class="fas fa-times text-xs p-2"></i>
                                </button>
                                
                                <!-- File Info -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-2">
                                    <div class="text-white text-xs truncate">
                                        <i class="fas fa-file-image mr-1"></i>
                                        <span>{{ $photo->getClientOriginalName() }}</span>
                                    </div>
                                    <div class="text-white/80 text-xxs">
                                        {{ $this->formatBytes($photo->getSize()) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tips -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center text-blue-800 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>
                        <span class="font-semibold">Tips Upload Foto:</span>
                    </div>
                    <ul class="space-y-1 text-blue-700 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-check mt-0.5 mr-2 text-blue-600 text-xs"></i>
                            <span>Foto pertama otomatis jadi thumbnail</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mt-0.5 mr-2 text-blue-600 text-xs"></i>
                            <span>Klik foto lain untuk ganti thumbnail</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check mt-0.5 mr-2 text-blue-600 text-xs"></i>
                            <span>Upload 5-8 foto untuk hasil terbaik</span>
                        </li>
                    </ul>
                </div>
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

                    <!-- Price Input -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1 sm:mb-3 text-sm sm:text-base">
                            <i class="fas fa-tag mr-1 sm:mr-2"></i>Harga Paket <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="relative max-w-md">
                            <span class="absolute left-3 sm:left-4 top-2 sm:top-3 text-gray-500 font-medium text-sm sm:text-base">Rp</span>
                            
                            <input type="text" 
                                wire:model.live="price_input"
                                class="w-full pl-8 sm:pl-12 pr-10 sm:pr-12 py-2 sm:py-3 border {{ $errors->has('price_input') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                                placeholder="0"
                                inputmode="numeric">
                                
                            <div class="absolute right-3 sm:right-4 top-2 sm:top-3 text-gray-500 text-sm sm:text-base">,00</div>
                        </div>
                        
                        @if($price_input)
                        <div class="mt-2 text-sm text-green-600 font-medium">
                            <i class="fas fa-eye mr-1"></i>
                            Preview: <span class="font-bold">Rp {{ $this->formattedPrice }}</span>
                        </div>
                        @endif
                        
                        @error('price_input')
                            <div class="text-red-500 text-xs sm:text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                                {{ $message }}
                            </div>
                        @enderror
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

                    <!-- Terms -->
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

        <!-- STEP 4: CONFIRMATION -->
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
                <!-- Business Info -->
                <div class="mb-6">
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center">
                        <i class="fas fa-store text-purple-600 mr-1 sm:mr-2"></i>
                        Informasi Bisnis
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-6">
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs sm:text-sm text-gray-500">Nama Bisnis</label>
                                <p class="font-medium">{{ $business_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs sm:text-sm text-gray-500">Kategori</label>
                                <p class="font-medium">
                                    @foreach($this->categories as $cat)
                                        @if($cat->id == $category_id) {{ $cat->name }} @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs sm:text-sm text-gray-500">Lokasi</label>
                                <p class="font-medium">{{ $location }}</p>
                            </div>
                            <div>
                                <label class="text-xs sm:text-sm text-gray-500">Tahun Berdiri</label>
                                <p class="font-medium">{{ $year_established ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div class="mb-6">
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center">
                        <i class="fas fa-images text-blue-600 mr-1 sm:mr-2"></i>
                        Foto & Galeri
                    </h3>
                    <div class="mb-2">
                        <p class="font-medium">{{ count($photos) }} foto terupload</p>
                    </div>
                    
                    @if(count($photos) > 0)
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                        @foreach($photos as $index => $photo)
                        <div class="relative">
                            @if(method_exists($photo, 'temporaryUrl'))
                                <img src="{{ $photo->temporaryUrl() }}" 
                                    class="w-full h-20 sm:h-24 object-cover rounded border {{ $index == $thumbnailIndex ? 'border-green-500' : 'border-gray-200' }}">
                            @else
                                <div class="w-full h-20 sm:h-24 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            @if($index == $thumbnailIndex)
                            <div class="absolute top-1 left-1 bg-green-600 text-white text-xxs px-1 py-0.5 rounded">
                                <i class="fas fa-star"></i>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Package -->
                <div class="mb-6">
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center">
                        <i class="fas fa-gift text-purple-600 mr-1 sm:mr-2"></i>
                        Paket & Harga
                    </h3>
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-4 sm:p-6 rounded-lg">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                            <div class="mb-2 sm:mb-0">
                                <h4 class="text-base sm:text-xl font-bold text-gray-800">{{ $package_name }}</h4>
                                <div class="text-lg sm:text-2xl font-bold text-purple-600 mt-1 sm:mt-2">
                                    Rp {{ $this->formattedPrice }}
                                </div>
                            </div>
                            @if($validity_period)
                            <div class="bg-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $validity_period }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Final Note -->
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-info-circle text-yellow-600 text-lg mr-2 mt-0.5"></i>
                        <div>
                            <p class="font-medium text-gray-800 mb-1 text-sm sm:text-base">Proses Selanjutnya</p>
                            <ul class="text-gray-600 space-y-1 text-xs sm:text-sm">
                                <li><i class="fas fa-check-circle text-green-500 mr-2"></i>Listing akan ditinjau oleh admin</li>
                                <li><i class="fas fa-bell text-blue-500 mr-2"></i>Anda akan mendapat notifikasi</li>
                                <li><i class="fas fa-store text-purple-500 mr-2"></i>Listing akan muncul di homepage</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Navigation Buttons -->
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
        </div>
    </div>
</div>

<!-- JavaScript for Photo Upload -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add CSS styles
    const style = document.createElement('style');
    style.textContent = `
        /* Counter Badge */
        .counter-badge {
            background: #3b82f6;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
        }
        
        /* Error Message */
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 6px 12px;
            border-radius: 6px;
            border-left: 4px solid #dc2626;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        /* Remove Button */
        .remove-btn {
            width: 24px;
            height: 24px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .group:hover .remove-btn {
            opacity: 1;
        }
        
        /* Mobile: Always Visible */
        @media (max-width: 767px) {
            .remove-btn {
                opacity: 1 !important;
                width: 32px !important;
                height: 32px !important;
                background: #ef4444 !important;
                box-shadow: 0 3px 8px rgba(0,0,0,0.4) !important;
                border: 2px solid white !important;
            }
            .remove-btn i {
                font-size: 14px !important;
            }
            .remove-btn:active {
                transform: scale(0.9);
                background: #dc2626 !important;
            }
        }
        
        /* Text Sizes */
        .text-xxs {
            font-size: 0.65rem;
        }
        
        /* Animations */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        /* Custom Modal */
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .custom-modal.active {
            opacity: 1;
            pointer-events: all;
        }
        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transform: translateY(20px);
            transition: transform 0.3s;
        }
        .custom-modal.active .modal-content {
            transform: translateY(0);
        }
    `;
    document.head.appendChild(style);
    
    // Initialize photo upload functionality
    initPhotoUpload();
});

function initPhotoUpload() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('livewirePhotoInput');
    const uploadSpinner = document.getElementById('uploadSpinner');
    const statusText = document.getElementById('statusText');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    if (!dropZone || !fileInput) return;
    
    // Drag and drop events
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50');
    });
    
    dropZone.addEventListener('dragleave', function() {
        dropZone.classList.remove('border-green-500', 'bg-green-50');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        
        const files = Array.from(e.dataTransfer.files)
            .filter(file => file.type.startsWith('image/'));
            
        if (files.length > 0) {
            handleFileSelection(files);
        }
    });
    
    // File input change event
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        if (files.length > 0) {
            handleFileSelection(files);
        }
    });
    
    function handleFileSelection(files) {
        const currentCount = document.querySelectorAll('#photosGrid > div').length;
        const maxPhotos = 10;
        const availableSlots = maxPhotos - currentCount;
        
        if (availableSlots <= 0) {
            showError(`Maksimal ${maxPhotos} foto sudah tercapai`);
            fileInput.value = '';
            return;
        }
        
        if (files.length > availableSlots) {
            const excess = files.length - availableSlots;
            showError(`Maksimal ${maxPhotos} foto. ${excess} foto akan diabaikan.`);
            
            // Keep only available slots
            const validFiles = files.slice(0, availableSlots);
            const dataTransfer = new DataTransfer();
            validFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
        
        // Show upload progress
        showUploadProgress();
        
        // Livewire will handle the upload automatically via wire:model
        // We just show UI feedback
        
        // Auto hide error after 5 seconds
        setTimeout(hideError, 5000);
    }
    
    function showUploadProgress() {
        if (uploadSpinner) uploadSpinner.classList.remove('hidden');
        if (statusText) statusText.textContent = 'Uploading...';
        
        // Hide after 2 seconds (simulation)
        setTimeout(() => {
            if (uploadSpinner) uploadSpinner.classList.add('hidden');
            if (statusText) statusText.textContent = 'Ready';
            updatePhotoCounter();
        }, 2000);
    }
    
    function showError(message) {
        if (errorMessage && errorText) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    }
    
    function hideError() {
        if (errorMessage) {
            errorMessage.classList.add('hidden');
        }
    }
    
    function updatePhotoCounter() {
        const count = document.querySelectorAll('#photosGrid > div').length;
        const counterElement = document.getElementById('photoCounter');
        if (counterElement) {
            counterElement.textContent = count;
        }
        
        // Update status text
        if (statusText) {
            if (count >= 2) {
                statusText.innerHTML = '<span class="text-green-600">✓ Siap lanjut</span>';
            } else {
                statusText.textContent = `Butuh ${2 - count} foto lagi`;
            }
        }
        
        // Show/hide error for max limit
        if (count >= 10) {
            showError(`Maksimal 10 foto sudah tercapai`);
        } else {
            hideError();
        }
    }
    
    // Custom confirm modal for delete
    window.showConfirmModal = function(filename, index) {
        // Remove existing modal
        const existingModal = document.getElementById('customConfirmModal');
        if (existingModal) existingModal.remove();
        
        // Create new modal
        const modal = document.createElement('div');
        modal.id = 'customConfirmModal';
        modal.className = 'custom-modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-center mb-2">Hapus Foto?</h3>
                    <p class="text-gray-600 text-center">Hapus foto "${filename}"?</p>
                </div>
                <div class="flex gap-3">
                    <button id="modalCancel" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button id="modalConfirm" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Show modal
        setTimeout(() => modal.classList.add('active'), 10);
        
        // Event listeners
        document.getElementById('modalCancel').addEventListener('click', () => {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        });
        
        document.getElementById('modalConfirm').addEventListener('click', () => {
            // Call Livewire method to remove photo
            Livewire.dispatch('remove-photo', { index: index });
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
            
            // Update counter after deletion
            setTimeout(updatePhotoCounter, 500);
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                setTimeout(() => modal.remove(), 300);
            }
        });
    };
    
    // Initialize counter on load
    updatePhotoCounter();
}

// Alpine.js component for photo upload (simplified)
function photoUploadApp() {
    return {
        init() {
            console.log('Photo upload app initialized');
            // Alpine initialization code if needed
        }
    };
}
</script>