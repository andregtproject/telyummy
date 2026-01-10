<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'canteen_id', 'name', 'description', 'price', 'image', 'is_available',
    ];

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }
} 