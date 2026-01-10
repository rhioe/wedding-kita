<?php

namespace App\Livewire\Vendor\Steps;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class Step2PhotoUpload extends Component
{
    use WithFileUploads;

    public $listingData;
    public $step;
    
    // State management
    public $photos = [];           // Foto yang sudah diupload
    public $photoState = [];       // State per foto: uploading, progress, done, error
    public $uploads = [];          // Temporary upload objects
    public $thumbnailId = null;
    
    // UI State
    public $showDeleteModal = false;
    public $photoToDelete = null;
    
    // Validation counters
    public $totalUploaded = 0;
    public $maxPhotos = 10;

    protected $listeners = [
        'upload-registered',
        'upload-progress',
        'upload-finished', 
        'upload-error',
        'photo-added' => 'handlePhotoAdded',
        'photo-duplicate' => 'handleDuplicate',
        'photo-limit-reached' => 'handleLimitReached',
    ];

    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        
        // Load existing photos
        $this->photos = $this->listingData['photos'] ?? [];
        $this->thumbnailId = $this->listingData['thumbnail_id'] ?? null;
        
        // Initialize state for existing photos
        foreach ($this->photos as $photo) {
            if (!isset($photo['id'])) {
                $photo['id'] = 'photo_' . uniqid();
            }
            $this->photoState[$photo['id']] = [
                'status' => 'done',
                'progress' => 100,
                'message' => 'Uploaded',
            ];
        }
        
        $this->totalUploaded = count($this->photos);
        
        if (!$this->thumbnailId && count($this->photos) > 0) {
            $this->thumbnailId = $this->photos[0]['id'];
        }
    }

    // ======================
    // PARALLEL UPLOAD ENGINE
    // ======================

    public function updatedUploads($value, $key)
    {
        // $key format: "uid" (contoh: "abc123")
        if (!isset($this->photoState[$key])) {
            return;
        }

        $file = $this->uploads[$key];
        
        if (!$file) {
            $this->photoState[$key]['status'] = 'error';
            $this->photoState[$key]['message'] = 'File error';
            return;
        }

        // Simpan temporary URL untuk preview
        $this->photoState[$key]['preview'] = $file->temporaryUrl();
        
        // Validate single file
        $validationResult = $this->validateSingleFile($file, $key);
        
        if (!$validationResult['valid']) {
            $this->photoState[$key]['status'] = 'error';
            $this->photoState[$key]['message'] = $validationResult['message'];
            $this->dispatch('upload-error', uid: $key, message: $validationResult['message']);
            return;
        }

        // Upload file (Livewire akan handle secara async)
        try {
            $path = $file->store('temp/photos', 'public');
            
            $this->photoState[$key]['status'] = 'done';
            $this->photoState[$key]['progress'] = 100;
            $this->photoState[$key]['path'] = $path;
            
            // Add to photos array
            $this->addPhotoToCollection($key);
            
            $this->dispatch('upload-finished', uid: $key);
            
        } catch (\Exception $e) {
            $this->photoState[$key]['status'] = 'error';
            $this->photoState[$key]['message'] = 'Upload failed';
            $this->dispatch('upload-error', uid: $key, message: 'Upload failed');
        }
    }

    #[On('upload-progress')]
    public function updateProgress($uid, $progress)
    {
        if (isset($this->photoState[$uid]) && $this->photoState[$uid]['status'] === 'uploading') {
            $this->photoState[$uid]['progress'] = $progress;
        }
    }

    #[On('upload-finished')]
    public function handleUploadFinished($uid)
    {
        if (isset($this->photoState[$uid])) {
            $this->photoState[$uid]['status'] = 'done';
            $this->photoState[$uid]['progress'] = 100;
        }
    }

    #[On('upload-error')]
    public function handleUploadError($uid, $message)
    {
        if (isset($this->photoState[$uid])) {
            $this->photoState[$uid]['status'] = 'error';
            $this->photoState[$uid]['message'] = $message;
        }
    }

    // ======================
    // VALIDATION LOGIC
    // ======================

    private function validateSingleFile($file, $uid)
    {
        $filename = $file->getClientOriginalName();
        
        // 1. Check duplicate
        foreach ($this->photos as $photo) {
            if (($photo['name'] ?? '') === $filename) {
                $this->dispatch('photo-duplicate', filename: $filename);
                return [
                    'valid' => false,
                    'message' => 'Foto sudah ada'
                ];
            }
        }

        // 2. Check max limit (ACCUMULATIVE)
        $currentlyUploading = count(array_filter($this->photoState, fn($state) => 
            in_array($state['status'], ['uploading', 'pending'])
        ));
        
        $totalAfterUpload = $this->totalUploaded + $currentlyUploading;
        
        if ($totalAfterUpload >= $this->maxPhotos) {
            $this->dispatch('photo-limit-reached', 
                current: $this->totalUploaded,
                trying: $currentlyUploading + 1,
                max: $this->maxPhotos
            );
            return [
                'valid' => false,
                'message' => 'Maksimal 10 foto'
            ];
        }

        // 3. Check file type
        if (!str_starts_with($file->getMimeType(), 'image/')) {
            return [
                'valid' => false,
                'message' => 'Hanya file gambar'
            ];
        }

        // 4. Check file size (max 5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return [
                'valid' => false,
                'message' => 'Maksimal 5MB per foto'
            ];
        }

        return ['valid' => true, 'message' => ''];
    }

    private function addPhotoToCollection($uid)
    {
        if (!isset($this->photoState[$uid]) || !isset($this->uploads[$uid])) {
            return;
        }

        $file = $this->uploads[$uid];
        
        $newPhoto = [
            'id' => $uid,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'path' => $this->photoState[$uid]['path'] ?? null,
            'preview' => $this->photoState[$uid]['preview'] ?? $file->temporaryUrl(),
            'type' => $file->getMimeType(),
            'uploaded_at' => now()->toDateTimeString(),
        ];

        $this->photos[] = $newPhoto;
        $this->totalUploaded++;
        
        if (!$this->thumbnailId) {
            $this->thumbnailId = $uid;
        }
        
        $this->dispatch('photo-added', photo: $newPhoto);
        $this->syncToParent();
    }

    // ======================
    // UI ACTIONS
    // ======================

    public function confirmDelete($photoId)
    {
        $this->photoToDelete = $photoId;
        $this->showDeleteModal = true;
    }

    public function removePhoto()
    {
        if (!$this->photoToDelete) return;

        $index = collect($this->photos)->search(function ($photo) {
            return $photo['id'] === $this->photoToDelete;
        });

        if ($index !== false) {
            array_splice($this->photos, $index, 1);
            $this->totalUploaded--;
            
            // Clean up state
            unset($this->photoState[$this->photoToDelete]);
            unset($this->uploads[$this->photoToDelete]);
            
            if ($this->thumbnailId === $this->photoToDelete) {
                $this->thumbnailId = count($this->photos) > 0 ? $this->photos[0]['id'] : null;
            }
            
            $this->dispatch('photo-deleted', photoId: $this->photoToDelete);
            $this->syncToParent();
        }

        $this->closeDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->photoToDelete = null;
    }

    public function setThumbnail($photoId)
    {
        if (collect($this->photos)->contains('id', $photoId)) {
            $this->thumbnailId = $photoId;
            $this->dispatch('thumbnail-changed', photoId: $photoId);
            $this->syncToParent();
        }
    }

    // ======================
    // NOTIFICATION HANDLERS
    // ======================

    public function handlePhotoAdded($event)
    {
        $this->dispatch('show-notification', 
            type: 'success',
            message: 'Foto ditambahkan: ' . $event['photo']['name']
        );
    }

    public function handleDuplicate($event)
    {
        $this->dispatch('show-notification',
            type: 'warning',
            message: 'Foto duplikat: ' . $event['filename'] . ' (tidak ditambahkan)'
        );
    }

    public function handleLimitReached($event)
    {
        $available = $event['max'] - $event['current'];
        $this->dispatch('show-notification',
            type: 'error',
            message: "Maksimal {$event['max']} foto. Hanya {$available} foto lagi yang bisa ditambahkan."
        );
    }

    // ======================
    // PARENT SYNC
    // ======================

    public function syncToParent()
    {
        $this->dispatch('step2-updated', [
            'photos' => $this->photos,
            'thumbnail_id' => $this->thumbnailId
        ]);
    }

    public function validateStep()
    {
        if (count($this->photos) < 2) {
            $this->addError('photos', 'Minimal 2 foto');
            $this->dispatch('show-notification',
                type: 'error',
                message: 'Minimal perlu 2 foto untuk melanjutkan'
            );
            return false;
        }
        
        // Check if any uploads are still in progress
        $uploading = collect($this->photoState)->contains('status', 'uploading');
        if ($uploading) {
            $this->addError('photos', 'Masih ada foto yang sedang diupload');
            $this->dispatch('show-notification',
                type: 'warning',
                message: 'Tunggu hingga semua foto selesai diupload'
            );
            return false;
        }
        
        $this->syncToParent();
        $this->dispatch('step-validated', step: 2);
        return true;
    }

    public function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return number_format($bytes / pow($k, $i), 1) . ' ' . $sizes[$i];
    }

    public function getPhotoStatus($photoId)
    {
        return $this->photoState[$photoId] ?? [
            'status' => 'done',
            'progress' => 100,
            'message' => 'Uploaded'
        ];
    }

    public function render()
    {
        return view('livewire.vendor.steps.step2-photo-upload', [
            'photoStates' => $this->photoState,
        ]);
    }
}