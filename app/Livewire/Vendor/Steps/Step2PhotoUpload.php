<?php
// app\Livewire\Vendor\Steps\Step2PhotoUpload.php

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
    
    // Toast
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
        
        $this->photos = $this->listingData['photos'] ?? [];
        $this->thumbnailId = $this->listingData['thumbnail_id'] ?? null;
    }

    public function updatedNewPhotos()
    {
        if (empty($this->newPhotos)) return;
        
        $added = 0;
        $duplicates = [];
        
        foreach ($this->newPhotos as $file) {
            // Max 10
            if (count($this->photos) >= 10) {
                $this->showToast('Maksimal 10 foto', 'warning');
                break;
            }
            
            // Check duplicate
            $fileName = $file->getClientOriginalName();
            if ($this->isDuplicate($fileName)) {
                $duplicates[] = $fileName;
                continue;
            }
            
            // Add photo
            $photoId = 'photo_' . uniqid();
            
            $this->photos[] = [
                'id' => $photoId,
                'name' => $fileName,
                'size' => $file->getSize(),
                'preview' => $file->temporaryUrl(),
                'file' => $file,
            ];
            
            $added++;
        }
        
        // Show toast
        if (!empty($duplicates)) {
            $this->showToast(count($duplicates) . ' foto duplikat diabaikan', 'warning');
        }
        
        if ($added > 0) {
            $this->showToast($added . ' foto ditambahkan', 'success');
            
            // Auto select thumbnail
            if (!$this->thumbnailId && !empty($this->photos)) {
                $this->thumbnailId = $this->photos[0]['id'];
            }
        }
        
        $this->reset('newPhotos');
        $this->syncToParent();
    }
    
    private function isDuplicate($fileName)
    {
        foreach ($this->photos as $photo) {
            if ($photo['name'] === $fileName) {
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
            // Remove photo
            $this->photos = array_filter($this->photos, function($photo) {
                return $photo['id'] !== $this->photoToDelete;
            });
            
            $this->photos = array_values($this->photos);
            
            // Update thumbnail
            if ($this->thumbnailId === $this->photoToDelete) {
                $this->thumbnailId = !empty($this->photos) ? $this->photos[0]['id'] : null;
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
        
        // Auto hide - akan di-handle oleh JavaScript di blade
    }
    
    public function syncToParent()
    {
        $metadata = [];
        foreach ($this->photos as $photo) {
            $metadata[] = [
                'id' => $photo['id'],
                'name' => $photo['name'],
                'size' => $photo['size'],
                'preview' => $photo['preview'],
                'file' => $photo['file'] // ✅ TAMBAHKAN FILE OBJECT
            ];
        }
        
        $this->dispatch('step2-updated', [
            'photos' => $metadata,
            'thumbnail_id' => $this->thumbnailId
        ]);
    }
    
    public function validateStep()
    {
        if (count($this->photos) < 2) {
            $this->showToast('Minimal 2 foto diperlukan', 'error');
            return false;
        }
        
        if (!$this->thumbnailId) {
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