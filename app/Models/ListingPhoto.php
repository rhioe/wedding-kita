<?php

// app/Models/ListingPhoto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingPhoto extends Model
{
    protected $fillable = [
        'listing_id',
        'path',                // original_path di database disebut 'path'
        'compressed_path',
        'processing_status',   // di database disebut 'processing_status'
        'order',
        'original_size_kb',
        'compressed_size_kb',
        'is_thumbnail',
    ];

    protected $casts = [
        'original_size_kb' => 'float',
        'compressed_size_kb' => 'float',
        'order' => 'integer',
        'is_thumbnail' => 'boolean',
    ];

    // Status constants - match dengan enum di database
    const STATUS_PENDING = 'pending';

    const STATUS_PROCESSING = 'processing';

    const STATUS_COMPLETED = 'completed';

    const STATUS_FAILED = 'failed';

    // Untuk compatibility dengan kode kita
    const STATUS_PENDING_COMPRESSION = 'pending'; // alias

    const STATUS_COMPRESSED = 'completed';        // alias

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the display path (compressed first, fallback to original)
     */
    public function getDisplayPathAttribute(): ?string
    {
        if ($this->compressed_path) {
            return $this->compressed_path;
        }

        return $this->path; // original path
    }

    /**
     * Check if photo is ready for display
     */
    public function isReadyForDisplay(): bool
    {
        return $this->processing_status === self::STATUS_COMPLETED && $this->compressed_path;
    }

    /**
     * Alias untuk kode kita yang pakai 'status'
     */
    public function getStatusAttribute()
    {
        return $this->processing_status;
    }

    /**
     * Alias untuk kode kita yang pakai 'original_path'
     */
    public function getOriginalPathAttribute()
    {
        return $this->path;
    }

    /**
     * Setter untuk 'status'
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['processing_status'] = $value;
    }

    /**
     * Setter untuk 'original_path'
     */
    public function setOriginalPathAttribute($value)
    {
        $this->attributes['path'] = $value;
    }
}
