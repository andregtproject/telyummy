<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}