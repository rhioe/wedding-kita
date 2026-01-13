<?php
// app/Models/Listing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Listing extends Model
{
    protected $fillable = [
        'vendor_id', 
        'category_id', 
        'title', 
        'slug',           // ✅ Tambah slug
        'description', 
        'price', 
        'location', 
        'business_name', 
        'year_established',
        'instagram', 
        'website', 
        'package_description', 
        'validity_period',
        'status',
        'published_at',   // ✅ Tambah published_at
        'views_count',    // ✅ Tambah views_count
        'is_featured',    // ✅ Tambah is_featured
        'whatsapp_clicks', // ✅ Tambah whatsapp_clicks
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug sebelum create
        static::creating(function ($listing) {
            if (empty($listing->slug)) {
                $listing->slug = static::generateSlug($listing->title);
            }
        });

        // Auto-update slug jika title berubah
        static::updating(function ($listing) {
            if ($listing->isDirty('title') && empty($listing->slug)) {
                $listing->slug = static::generateSlug($listing->title);
            }
        });
    }

    /**
     * Generate SEO-friendly slug
     */
    public static function generateSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        // Cek jika slug sudah ada
        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope untuk listing yang sudah published
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'approved')
                     ->whereNotNull('published_at');
    }

    /**
     * Scope untuk featured listings
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->published();
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment WhatsApp clicks
     */
    public function incrementWhatsAppClicks()
    {
        $this->increment('whatsapp_clicks');
    }

    // Relations (tetap sama)
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class);
    }
}