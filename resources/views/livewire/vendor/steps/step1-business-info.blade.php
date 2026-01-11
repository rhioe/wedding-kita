{{-- resources\views\livewire\vendor\steps\step1-business-info.blade.php --}}

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
                    <input type="text" wire:model.live="business_name"
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
                    <select wire:model.live="category_id"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('category_id') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
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
                    <input type="text" wire:model.live="location"
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
            <!-- Ganti bagian description ini: -->
    <div>
        <label class="block text-gray-700 font-semibold mb-1 sm:mb-2 text-sm sm:text-base">
            Deskripsi Bisnis <span class="text-red-500">*</span>
        </label>
        <textarea 
            wire:model.live="description"
            rows="5"
            class="w-full px-3 sm:px-4 py-2 sm:py-3 border {{ $errors->has('description') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
            placeholder="Jelaskan keunikan, pengalaman, dan keunggulan bisnis Anda..."
        ></textarea>
        
        <!-- Character counter tanpa Alpine -->
        <div class="flex justify-between mt-1 sm:mt-2">
            <div class="text-xs sm:text-sm {{ strlen($description) >= 50 ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                <i class="fas fa-ruler mr-1 text-xs"></i>
                {{ strlen($description) }}/50 karakter
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
                    <input type="number" wire:model.live="year_established"
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
                <!-- WhatsApp (Readonly dari user) -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1 sm:mb-2 text-sm sm:text-base">
                        WhatsApp
                    </label>
                    <div class="flex flex-col p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fab fa-whatsapp text-green-500 text-base sm:text-lg mr-2 sm:mr-3"></i>
                            <div class="flex-1">
                                <span class="text-gray-700 font-medium text-sm sm:text-base">
                                    {{ auth()->user()->phone ?? '6281234567890' }}
                                </span>
                                <a href="https://wa.me/{{ auth()->user()->phone ?? '6281234567890' }}" target="_blank" 
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
                        <input type="text" wire:model.live="instagram"
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
                <input type="url" wire:model.live="website"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition text-sm sm:text-base"
                    placeholder="https://contoh.com">
            </div>
        </div>
    </div>
</div>