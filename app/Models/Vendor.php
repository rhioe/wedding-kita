<?php
// app/Models/Vendor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'category',
        'location',
        'description',
        'year_established',
        'whatsapp_number',
        'instagram',
        'website',
        'status',
        'slug',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug sebelum create
        static::creating(function ($vendor) {
            if (empty($vendor->slug)) {
                $vendor->slug = static::generateSlug($vendor->business_name);
            }
        });

        // Auto-update slug jika business_name berubah
        static::updating(function ($vendor) {
            if ($vendor->isDirty('business_name') && empty($vendor->slug)) {
                $vendor->slug = static::generateSlug($vendor->business_name);
            }
        });
    }

    /**
     * Generate unique slug
     */
    public static function generateSlug(string $businessName): string
    {
        $baseSlug = Str::slug($businessName);
        $slug = $baseSlug;
        $counter = 1;

        // Cek jika slug sudah ada
        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}