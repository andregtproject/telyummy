<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Agar semua kolom bisa diisi (mass assignment)

    // Relasi Order milik 1 User (Pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Order milik 1 Kantin
    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }
}