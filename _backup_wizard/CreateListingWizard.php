<?php

namespace App\Livewire\Vendor\Listings;

use App\Models\Category;
use App\Models\Listing;
use App\Services\ImageCompressorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateListingWizard extends Component
{
    use WithFileUploads;

    // Step management
    public $currentStep = 1;

    public $totalSteps = 4;

    // Step 1: Business Information
    public $business_name = '';

    public $category_id = '';

    public $location = '';

    public $description = '';

    public $year_established = '';

    public $instagram = '';

    public $website = '';

    // Step 2: Photos - NEW STRUCTURE FOR PROGRESS
    public $photos = []; // Final uploaded photos

    public $newPhotos = []; // Temporary for upload

    public $photoStatuses = []; // Track progress per photo

    public $thumbnailIndex = 0; // <-- TAMBAH INI

    // Global upload state
    public $isUploading = false;

    public $totalUploadProgress = 0;

    public $uploadStatusMessage = '';

    // Step 3: Package & Pricing
    public $package_name = '';

    public $price_input = '';

    public $package_description = '';

    public $validity_period = '';

    public $terms_accepted = false;

    // Computed properties
    public function getCategoriesProperty()
    {
        return Category::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function getFormattedPhoneProperty()
    {
        return auth()->user()->phone ?? '6281234567890';
    }

    public function getWhatsAppLinkProperty()
    {
        return 'https://wa.me/'.$this->formattedPhone;
    }

    public function getFormattedPriceProperty()
    {
        $numeric = preg_replace('/[^0-9]/', '', $this->price_input);
        $numeric = intval($numeric) ?: 0;

        return number_format($numeric, 0, ',', '.');
    }

    // ==================== PHOTO UPLOAD WITH PROGRESS ====================

    /**
     * Validate photos (min/max/duplicate)
     */
    private function validatePhotos()
    {
        $currentCount = count($this->photos);
        $newCount = count($this->newPhotos);
        $totalAfterUpload = $currentCount + $newCount;

        if ($totalAfterUpload > 10) {
            throw new \Exception('Maksimal 10 foto. Anda sudah upload '.$currentCount.' foto.');
        }

        if ($currentCount + $newCount < 2) {
            throw new \Exception('Minimal 2 foto. Upload '.(2 - $currentCount).' foto lagi.');
        }

        // Check duplicates
        $existingFilenames = collect($this->photos)->pluck('filename')->toArray();
        foreach ($this->newPhotos as $photo) {
            if (in_array($photo->getClientOriginalName(), $existingFilenames)) {
                throw new \Exception('Foto "'.$photo->getClientOriginalName().'" sudah ada.');
            }
        }
    }

    /**
     * Start photo upload process
     */
    public function startPhotoUpload()
    {
        try {
            // Validate before starting
            $this->validatePhotos();

            $this->validate([
                'newPhotos' => 'required|array|min:1|max:10',
                'newPhotos.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            ]);

            // Initialize upload state
            $this->isUploading = true;
            $this->totalUploadProgress = 0;
            $this->uploadStatusMessage = 'Menyiapkan upload...';

            // Initialize status for each new photo
            foreach ($this->newPhotos as $photo) {
                $filename = $photo->getClientOriginalName();
                $this->photoStatuses[$filename] = [
                    'status' => 'pending', // pending, uploading, compressing, completed, error
                    'progress' => 0,
                    'message' => 'Menunggu...',
                    'size' => $this->formatBytes($photo->getSize()),
                    'preview_url' => $photo->temporaryUrl(),
                ];
            }

            // Start actual upload (non-blocking)
            $this->dispatch('start-background-upload');

        } catch (\Exception $e) {
            $this->dispatch('toast-message', ['error', $e->getMessage()]);
            $this->resetUploadState();
        }
    }

    /**
     * Set thumbnail photo
     */
    public function setThumbnail($index) // <-- TAMBAH METHOD INI
    {
        if (isset($this->photos[$index])) {
            $this->thumbnailIndex = $index;
            $this->dispatch('toast-message', [
                'success',
                '✓ Thumbnail dipilih!',
            ]);
        }
    }

    /**
     * Process upload in background (called via JavaScript)
     */
    public function processPhotoUpload()
    {
        try {
            $totalPhotos = count($this->newPhotos);
            $processedCount = 0;

            foreach ($this->newPhotos as $index => $photo) {
                $filename = $photo->getClientOriginalName();
                $photoIndex = $index + 1;

                // === PHASE 1: UPLOAD ORIGINAL ===
                $this->updatePhotoStatus($filename, [
                    'status' => 'uploading',
                    'progress' => 25,
                    'message' => 'Mengupload original...',
                ]);

                $this->updateGlobalProgress($photoIndex, $totalPhotos, 0, 40);

                // Upload to temporary storage
                $tempPath = $photo->store('temp/listings/'.uniqid(), 'public');

                // === PHASE 2: COMPRESS TO 120KB ===
                $this->updatePhotoStatus($filename, [
                    'status' => 'compressing',
                    'progress' => 50,
                    'message' => 'Compressing ke 120KB...',
                ]);

                $this->updateGlobalProgress($photoIndex, $totalPhotos, 40, 80);

                // Compress image
                $compressor = new ImageCompressorService;
                $compressedPath = $compressor->saveCompressed(
                    Storage::path('public/'.$tempPath),
                    $filename
                );

                // === PHASE 3: FINALIZE ===
                $this->updatePhotoStatus($filename, [
                    'status' => 'completed',
                    'progress' => 100,
                    'message' => 'Selesai!',
                    'final_path' => $compressedPath,
                ]);

                $this->updateGlobalProgress($photoIndex, $totalPhotos, 80, 100);

                // Add to final photos array
                $this->photos[] = [
                    'filename' => $filename,
                    'path' => $compressedPath,
                    'preview_url' => Storage::url($compressedPath),
                    'size' => $this->formatBytes(Storage::size('public/'.$compressedPath)),
                ];

                $processedCount++;

                // Small delay for UI feedback
                usleep(300000); // 0.3s
            }

            // Final update
            $this->uploadStatusMessage = "{$processedCount}/{$totalPhotos} foto berhasil!";

            // Success notification
            if ($processedCount > 0) {
                $this->dispatch('toast-message', [
                    'success',
                    "✅ {$processedCount} foto berhasil diupload & dikompres!",
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Photo upload failed: '.$e->getMessage());
            $this->dispatch('toast-message', ['error', 'Upload gagal: '.$e->getMessage()]);
        } finally {
            // Clean up
            $this->newPhotos = [];
            $this->isUploading = false;
            $this->totalUploadProgress = 100;

            // Final delay for UI
            sleep(1);
            $this->totalUploadProgress = 0;
            $this->uploadStatusMessage = '';
        }
    }

    /**
     * Update individual photo status
     */
    private function updatePhotoStatus($filename, $updates)
    {
        if (isset($this->photoStatuses[$filename])) {
            $this->photoStatuses[$filename] = array_merge(
                $this->photoStatuses[$filename],
                $updates
            );
        }

        // Dispatch for real-time UI update
        $this->dispatch('photo-status-updated', [
            'filename' => $filename,
            'status' => $this->photoStatuses[$filename],
        ]);
    }

    /**
     * Update global progress
     */
    private function updateGlobalProgress($current, $total, $fromPercent, $toPercent)
    {
        $progressPerPhoto = ($toPercent - $fromPercent) / $total;
        $currentProgress = $fromPercent + ($progressPerPhoto * $current);

        $this->totalUploadProgress = min(100, round($currentProgress));
        $this->uploadStatusMessage = "Memproses foto {$current}/{$total}";
    }

    /**
     * Remove a photo
     */
    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            $filename = $this->photos[$index]['filename'];
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos); // Re-index

            // Adjust thumbnail index if needed
            if ($this->thumbnailIndex >= $index && $this->thumbnailIndex > 0) {
                $this->thumbnailIndex--;
            }

            // If thumbnail was removed and we still have photos, set first as thumbnail
            if (empty($this->photos)) {
                $this->thumbnailIndex = 0;
            } elseif ($this->thumbnailIndex >= count($this->photos)) {
                $this->thumbnailIndex = 0;
            }

            // Also remove from statuses if exists
            if (isset($this->photoStatuses[$filename])) {
                unset($this->photoStatuses[$filename]);
            }

            $this->dispatch('toast-message', ['success', "Foto '{$filename}' dihapus"]);
        }
    }

    /**
     * Cancel upload
     */
    public function cancelUpload()
    {
        $this->resetUploadState();
        $this->dispatch('toast-message', ['info', 'Upload dibatalkan']);
    }

    /**
     * Reset upload state
     */
    private function resetUploadState()
    {
        $this->isUploading = false;
        $this->newPhotos = [];
        $this->totalUploadProgress = 0;
        $this->uploadStatusMessage = '';
        $this->photoStatuses = [];
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 1)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }

    // ==================== STEP VALIDATION & NAVIGATION ====================

    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'business_name' => 'required|min:3|max:100',
                'category_id' => 'required|exists:categories,id',
                'location' => 'required|min:3|max:100',
                'description' => 'required|string|min:50|max:2000',
                'year_established' => 'nullable|integer|min:1900|max:'.date('Y'),
                'instagram' => 'nullable|string|max:30',
                'website' => 'nullable|url|max:255',
            ], [
                'business_name.required' => 'Nama bisnis wajib diisi',
                'category_id.required' => 'Pilih kategori bisnis',
                'location.required' => 'Lokasi wajib diisi',
                'description.required' => 'Deskripsi bisnis wajib diisi',
                'description.min' => 'Deskripsi minimal 50 karakter',
            ]);
        }

        if ($this->currentStep == 2) {
            $this->validate([
                'photos' => 'required|array|min:2|max:10',
            ], [
                'photos.required' => 'Upload minimal 2 foto',
                'photos.min' => 'Minimal 2 foto diperlukan',
                'photos.max' => 'Maksimal 10 foto',
            ]);
        }

        if ($this->currentStep == 3) {
            $numericPrice = intval(preg_replace('/[^0-9]/', '', $this->price_input));

            $this->validate([
                'package_name' => 'required|min:3|max:100',
                'price_input' => 'required',
                'package_description' => 'nullable|string|max:1000',
                'validity_period' => 'nullable|string|max:50',
                'terms_accepted' => 'accepted',
            ], [
                'package_name.required' => 'Nama paket wajib diisi',
                'price_input.required' => 'Harga paket wajib diisi',
                'terms_accepted.accepted' => 'Anda harus menyetujui syarat & ketentuan',
            ]);

            if ($numericPrice < 10000) {
                $this->addError('price_input', 'Harga minimal Rp 10.000');
                throw new \Exception('Harga minimal Rp 10.000');
            }
        }
    }

    public function updatedPriceInput($value)
    {
        $numeric = preg_replace('/[^0-9]/', '', $value);
        $numeric = intval($numeric) ?: '';

        if ($numeric !== '') {
            $formatted = number_format($numeric, 0, '', '.');
            $this->price_input = $formatted;
        } else {
            $this->price_input = '';
        }
    }

    public function nextStep()
    {
        try {
            $this->validateCurrentStep();

            if ($this->currentStep < $this->totalSteps) {
                $this->currentStep++;
                $this->dispatch('scroll-to-top');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('toast-message', ['error', $e->getMessage()]);
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('scroll-to-top');
        }
    }

    // ==================== SUBMIT LISTING ====================

    public function submit()
    {
        try {
            $this->validateCurrentStep();

            $numericPrice = intval(preg_replace('/[^0-9]/', '', $this->price_input));

            // Create listing
            $listing = Listing::create([
                'vendor_id' => auth()->user()->vendor->id,
                'category_id' => $this->category_id,
                'title' => $this->package_name,
                'slug' => Str::slug($this->package_name).'-'.uniqid(),
                'description' => $this->description,
                'price' => $numericPrice,
                'location' => $this->location,
                'business_name' => $this->business_name,
                'year_established' => $this->year_established ?: null,
                'instagram' => $this->instagram ?: null,
                'website' => $this->website ?: null,
                'package_description' => $this->package_description ?: null,
                'validity_period' => $this->validity_period ?: null,
                'status' => 'pending',
            ]);

            // Save photos
            foreach ($this->photos as $index => $photoData) {
                $listing->photos()->create([
                    'path' => $photoData['path'],
                    'is_thumbnail' => ($index == $this->thumbnailIndex), // Use thumbnailIndex
                    'order' => $index,
                ]);
            }

            // Success
            $this->dispatch('toast-message', [
                'success',
                '✅ Listing berhasil dibuat! Menunggu review admin.',
            ]);

            // Redirect
            sleep(2);

            return redirect()->route('vendor.listings.index');

        } catch (\Exception $e) {
            Log::error('Listing submission failed: '.$e->getMessage());
            $this->dispatch('toast-message', ['error', 'Gagal: '.$e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.vendor.listings.create-listing-wizard')
            ->layout('layouts.vendor', [
                'title' => 'Buat Listing Baru',
                'vendor' => auth()->user()->vendor ?? null,
            ]);
    }
}
