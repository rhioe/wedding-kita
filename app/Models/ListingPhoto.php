<?php
// app\Models\ListingPhoto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingPhoto extends Model
{
    protected $fillable = [
        'listing_id', 
        'path', 
        'compressed_path',           // ✅ TAMBAH
        'original_size_kb',          // ✅ TAMBAH
        'processing_status',         // ✅ TAMBAH
        'is_thumbnail', 
        'order'
    ];
    
    protected $attributes = [
        'processing_status' => 'pending', // ✅ DEFAULT VALUE
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
    
    // Di model ListingPhoto
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getThumbnailUrlAttribute()
    {
        // Jika ada compressed version, pakai itu
        if ($this->compressed_path && $this->processing_status === 'compressed') {
            return asset('storage/' . $this->compressed_path);
        }
        
        return asset('storage/' . $this->path);
    }

    public function getFileExistsAttribute()
    {
        return Storage::disk('public')->exists($this->path);
    }

    
}