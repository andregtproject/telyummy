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
        'rating',
        'is_open',
        'image',
        'latitude',
        'longitude',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}