<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail 
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // Role: pembeli/penjual
        'avatar',        // Foto profil
        'identity_card', // KTM (untuk pembeli)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi User (Penjual) memiliki satu Kantin
    public function canteen()
    {
        return $this->hasOne(Canteen::class);
    }

    // Relasi User (Pembeli) memiliki banyak Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}