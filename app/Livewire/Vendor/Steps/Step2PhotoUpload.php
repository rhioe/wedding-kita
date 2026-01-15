<?php

// app\Livewire\Vendor\Steps\Step2PhotoUpload.php

namespace App\Livewire\Vendor\Steps;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Step2PhotoUpload extends Component
{
    use WithFileUploads;

    public $listingData;

    public $step;

    public $photos = [];

    public $newPhotos = [];

    public $thumbnailId = null;

    public $showDeleteModal = false;

    public $photoToDelete = null;

    public $toastMessage = '';

    public $toastType = 'info';

    public $showToast = false;

    protected $listeners = [
        'validate-step-2' => 'validateStep',
    ];

    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;

        // Load existing photos from parent data
        if (! empty($this->listingData['photos'])) {
            $this->photos = [];
            foreach ($this->listingData['photos'] as $index => $photoData) {
                $this->photos[] = [
                    'id' => 'photo_'.$index,
                    'name' => $photoData['original_name'] ?? 'photo_'.$index.'.jpg',
                    'size' => $photoData['size'] ?? 0,
                    'preview' => '', // No preview in Step4 data
                    'temp_path' => $photoData['temp_path'] ?? '',
                ];
            }
        }

        $this->thumbnailId = $this->listingData['thumbnail_id'] ?? null;

        \Log::info('Step2 mounted with data:', [
            'parent_photos_count' => count($this->listingData['photos'] ?? []),
            'loaded_photos_count' => count($this->photos),
        ]);
    }

    public function updatedNewPhotos()
    {
        if (empty($this->newPhotos)) {
            return;
        }

        $added = 0;
        $duplicates = [];

        foreach ($this->newPhotos as $file) {
            // Max 10 foto
            if (count($this->photos) >= 10) {
                $this->showToast('Maksimal 10 foto', 'warning');
                break;
            }

            // Check duplicate by filename
            $fileName = $file->getClientOriginalName();
            if ($this->isDuplicate($fileName)) {
                $duplicates[] = $fileName;

                continue;
            }

            // ✅ Store to Livewire temporary storage
            // Livewire will automatically store in storage/app/livewire-tmp
            $photoId = 'photo_'.uniqid();

            $this->photos[] = [
                'id' => $photoId,
                'name' => $fileName,
                'size' => $file->getSize(),
                'preview' => $file->temporaryUrl(),
                'temp_path' => '', // Will be set when syncing
                'file_object' => $file, // Keep reference for sync
            ];

            $added++;
        }

        // Show notifications
        if (! empty($duplicates)) {
            $this->showToast(count($duplicates).' foto duplikat diabaikan', 'warning');
        }

        if ($added > 0) {
            $this->showToast($added.' foto ditambahkan', 'success');

            // Auto select thumbnail if none selected
            if (! $this->thumbnailId && ! empty($this->photos)) {
                $this->thumbnailId = $this->photos[0]['id'];
            }

            // Immediately sync to parent
            $this->syncToParent();
        }

        $this->reset('newPhotos');
    }

    private function isDuplicate($fileName)
    {
        foreach ($this->photos as $photo) {
            if (($photo['name'] ?? '') === $fileName) {
                return true;
            }
        }

        return false;
    }

    public function setThumbnail($photoId)
    {
        $this->thumbnailId = $photoId;
        $this->showToast('Thumbnail dipilih', 'success');
        $this->syncToParent();
    }

    public function confirmDelete($photoId)
    {
        $this->photoToDelete = $photoId;
        $this->showDeleteModal = true;
    }

    public function removePhoto()
    {
        if ($this->photoToDelete) {
            // Remove from array
            $this->photos = array_filter($this->photos, function ($photo) {
                return $photo['id'] !== $this->photoToDelete;
            });

            $this->photos = array_values($this->photos);

            // Update thumbnail if needed
            if ($this->thumbnailId === $this->photoToDelete) {
                $this->thumbnailId = ! empty($this->photos) ? $this->photos[0]['id'] : null;
            }

            $this->showToast('Foto dihapus', 'info');
            $this->syncToParent();
        }

        $this->closeDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->photoToDelete = null;
    }

    public function showToast($message, $type = 'info')
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;

        // Auto hide after 3 seconds
        $this->dispatch('toast-shown');
    }

    public function syncToParent()
    {
        $photoDataForParent = [];
        $thumbnailIndex = null;

        foreach ($this->photos as $index => $photo) {
            // Jika ada file object (baru diupload), simpan ke temp storage
            if (isset($photo['file_object']) && $photo['file_object'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Simpan file ke temp storage dengan unique name
                $tempFilename = Str::uuid().'.'.$photo['file_object']->getClientOriginalExtension();
                $tempPath = $photo['file_object']->storeAs('temp/photos', $tempFilename);

                // Update photo data
                $this->photos[$index]['temp_path'] = $tempPath;
                unset($this->photos[$index]['file_object']);
            }

            // Prepare data for parent
            $photoDataForParent[] = [
                'temp_path' => $this->photos[$index]['temp_path'] ?? '',
                'original_name' => $this->photos[$index]['name'] ?? '',
                'size' => $this->photos[$index]['size'] ?? 0,
            ];

            // Track thumbnail index
            if ($this->photos[$index]['id'] === $this->thumbnailId) {
                $thumbnailIndex = $index;
            }
        }

        \Log::info('Step2 syncing to parent:', [
            'photo_count' => count($photoDataForParent),
            'thumbnail_index' => $thumbnailIndex,
            'sample_data' => $photoDataForParent[0] ?? 'none',
        ]);

        // Save to session as backup
        session(['temp_photos_backup' => $photoDataForParent]);

        // Dispatch to parent
        $this->dispatch('step2-updated', [
            'photos' => $photoDataForParent,
            'thumbnail_index' => $thumbnailIndex,
        ]);
    }

    public function validateStep()
    {
        if (count($this->photos) < 2) {
            $this->showToast('Minimal 2 foto diperlukan', 'error');

            return false;
        }

        if (! $this->thumbnailId) {
            $this->showToast('Pilih thumbnail untuk listing', 'warning');

            return false;
        }

        $this->syncToParent();
        $this->dispatch('step-validated', 2);

        return true;
    }

    public function render()
    {
        return view('livewire.vendor.steps.step2-photo-upload');
    }
}
