<?php

namespace App\Services;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PhotoUploadService
{
    use WithFileUploads;

    /**
     * Cek apakah foto sudah ada (duplicate)
     */
    public function isDuplicate($newPhoto, $existingPhotos)
    {
        $newName = $newPhoto->getClientOriginalName();
        $newSize = $newPhoto->getSize();
        
        foreach ($existingPhotos as $existing) {
            // Cek jika existing adalah array
            if (is_array($existing) && isset($existing['filename'])) {
                if ($existing['filename'] === $newName) {
                    return true;
                }
            }
            
            // Cek jika existing adalah Livewire file object
            if (is_object($existing) && method_exists($existing, 'getClientOriginalName')) {
                if ($existing->getClientOriginalName() === $newName) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Validasi maksimal 10 foto
     */
    public function validateMaxPhotos($currentCount, $newCount)
    {
        $total = $currentCount + $newCount;
        
        if ($total > 10) {
            throw new \Exception("Maksimal 10 foto. Anda sudah upload {$currentCount} foto.");
        }
        
        return true;
    }
    
    /**
     * Validasi minimal 2 foto
     */
    public function validateMinPhotos($currentCount)
    {
        if ($currentCount < 2) {
            throw new \Exception("Minimal 2 foto. Upload " . (2 - $currentCount) . " foto lagi.");
        }
        
        return true;
    }
}