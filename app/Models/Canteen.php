<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Canteen extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'category',
        'rating',
        'is_open',
        'image',
        'latitude',
        'longitude',
        'location_description',
    ];

    // Relasi Kantin dimiliki oleh satu User (Penjual)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Kantin memiliki banyak Orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Relasi Kantin memiliki banyak Menu Items
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    // Get available menu items only
    public function availableMenuItems(): HasMany
    {
        return $this->menuItems()->where('is_available', true);
    }

    // Relasi Kantin memiliki banyak Feedbacks
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }
}
