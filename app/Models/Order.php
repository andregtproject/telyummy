<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Agar semua kolom bisa diisi (mass assignment)

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'integer',
    ];

    /**
     * Order status constants.
     */
    public const STATUS_MENUNGGU = 'menunggu';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_BATAL = 'batal';

    /**
     * Get all valid statuses.
     *
     * @return array<string>
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_MENUNGGU,
            self::STATUS_DIPROSES,
            self::STATUS_SELESAI,
            self::STATUS_BATAL,
        ];
    }

    // Relasi Order milik 1 User (Pembeli)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Order milik 1 Kantin
    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    // Relasi Order memiliki banyak Order Items
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Format total harga dalam Rupiah.
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Scope untuk filter berdasarkan status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check apakah order bisa di-cancel.
     */
    public function canBeCancelled(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    /**
     * Check apakah order bisa diproses.
     */
    public function canBeProcessed(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    /**
     * Check apakah order bisa diselesaikan.
     */
    public function canBeCompleted(): bool
    {
        return $this->status === self::STATUS_DIPROSES;
    }
}