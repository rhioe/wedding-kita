<?php

namespace App\Livewire\Vendor\Steps;

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

    public function mount($listingData, $step)
    {
        $this->listingData = $listingData;
        $this->step = $step;
        
        $this->photos = $this->listingData['photos'] ?? [];
        $this->thumbnailId = $this->listingData['thumbnail_id'] ?? null;
        
        // Generate IDs untuk existing photos
        foreach ($this->photos as &$photo) {
            if (!isset($photo['id'])) {
                $photo['id'] = 'photo_' . uniqid();
            }
        }
        
        if (!$this->thumbnailId && count($this->photos) > 0) {
            $this->thumbnailId = $this->photos[0]['id'];
        }
    }

    public function updatedNewPhotos()
    {
        if (empty($this->newPhotos)) return;
        
        $accepted = [];
        $duplicates = [];
        $rejectedLimit = [];

        foreach ($this->newPhotos as $file) {
            $name = $file->getClientOriginalName();

            // Check duplicate
            $exists = collect($this->photos)->firstWhere('name', $name);
            if ($exists) {
                $duplicates[] = $name;
                continue;
            }

            // Check max 10
            if (count($this->photos) + count($accepted) >= 10) {
                $rejectedLimit[] = $name;
                continue;
            }

            $accepted[] = [
                'id' => 'photo_' . uniqid() . '_' . time(),
                'name' => $name,
                'size' => $file->getSize(),
                'preview' => $file->temporaryUrl(),
            ];
        }

        // Add accepted photos
        foreach ($accepted as $photo) {
            $this->photos[] = $photo;
        }

        // Dispatch notifications
        if ($duplicates) {
            $dupList = implode(', ', array_slice($duplicates, 0, 3));
            if (count($duplicates) > 3) $dupList .= ' dan ' . (count($duplicates) - 3) . ' lainnya';
            $this->dispatch('upload-warning', message: 'Foto duplikat: ' . $dupList);
        }

        if ($rejectedLimit) {
            $this->dispatch('upload-warning', message: count($rejectedLimit) . ' foto tidak ditambahkan (maksimal 10 foto)');
        }

        if ($accepted) {
            $this->dispatch('photos-added', count: count($accepted));
        }

        if (!$this->thumbnailId && count($this->photos) > 0) {
            $this->thumbnailId = $this->photos[0]['id'];
        }

        $this->reset('newPhotos');
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
            $index = collect($this->photos)->search(function ($photo) {
                return $photo['id'] === $this->photoToDelete;
            });

            if ($index !== false) {
                array_splice($this->photos, $index, 1);
                
                if ($this->thumbnailId === $this->photoToDelete) {
                    $this->thumbnailId = count($this->photos) > 0 ? $this->photos[0]['id'] : null;
                }
                
                $this->syncToParent();
                $this->dispatch('photo-deleted', photoId: $this->photoToDelete);
            }
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
        $exists = collect($this->photos)->contains('id', $photoId);
        if ($exists) {
            $this->thumbnailId = $photoId;
            $this->dispatch('thumbnail-changed', photoId: $photoId);
        }
    }

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
            return false;
        }
        
        $this->syncToParent();
        $this->dispatch('step-validated', 2);
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

    public function render()
    {
        return view('livewire.vendor.steps.step2-photo-upload');
    }
}