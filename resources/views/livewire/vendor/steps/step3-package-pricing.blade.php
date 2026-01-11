{{-- resources\views\livewire\vendor\steps\step3-package-pricing.blade.php --}}

<div class="min-h-screen bg-gray-50 p-4">
    <div class="max-w-2xl mx-auto">

        <!-- Step Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Detail Paket & Harga</h2>
            <p class="text-gray-600 mt-2">Isi informasi paket layanan Anda</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <div class="space-y-6">

                <!-- Package Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Paket *
                    </label>
                    <input type="text"
                        wire:model.defer="package_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Paket Foto Prewedding Premium">

                    @error('package_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div x-data="{ raw: @entangle('price').live }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (IDR) *
                    </label>

                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                            Rp
                        </div>

                        <input type="text"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="2.000.000"
                            x-init="
                                if(raw) {
                                    $el.value = new Intl.NumberFormat('id-ID').format(raw);
                                }
                            "
                            x-on:input="
                                raw = $event.target.value.replace(/\D/g,'');
                                $event.target.value = raw 
                                    ? new Intl.NumberFormat('id-ID').format(raw)
                                    : '';
                            ">
                    </div>

                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Package Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Paket
                    </label>

                    <textarea
                        wire:model.defer="package_description"
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Jelaskan detail paket, apa saja yang termasuk, durasi, dll..."></textarea>

                    <div class="mt-1 text-sm text-gray-500">
                        {{ strlen($package_description ?? '') }}/1000 karakter
                    </div>
                </div>

                <!-- Validity Period -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Masa Berlaku
                    </label>

                    <input type="text"
                        wire:model.defer="validity_period"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: 6 bulan, 1 tahun, hingga 31 Desember 2024">

                    <p class="mt-1 text-sm text-gray-500">
                        Kosongkan jika tidak ada masa berlaku khusus
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm text-blue-800">
                                Harga yang Anda masukkan akan ditampilkan kepada calon pengantin.
                                Pastikan harga sudah termasuk semua biaya yang diperlukan.
                            </p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
