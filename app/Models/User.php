<?php
//app\Models\User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is a vendor
     */
    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the vendor profile
     */
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    /**
     * Format whatsapp number for display
     */
    public function getFormattedWhatsappAttribute(): string
    {
        if (!$this->whatsapp) return '';
        
        $number = $this->whatsapp;
        if (str_starts_with($number, '62')) {
            return '0' . substr($number, 2);
        }
        
        return $number;
    }

    /**
     * Format whatsapp number for WhatsApp link
     */
    public function getWhatsappLinkAttribute(): string
    {
        if (!$this->whatsapp) return '';
        
        return 'https://wa.me/' . $this->whatsapp;
    }
}