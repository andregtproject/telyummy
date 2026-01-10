<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'canteen_id',
        'name',
        'description',
        'price',
        'category',
        'image',
        'is_available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
        'is_available' => 'boolean',
    ];

    /**
     * Get the canteen that owns this menu item.
     */
    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    /**
     * Get all order items for this menu item.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Format harga dalam Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Scope untuk menu yang tersedia.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope untuk filter berdasarkan kategori.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get all unique categories dari database.
     *
     * @return array<string>
     */
    public static function getCategories(): array
    {
        $defaults = ['Makanan', 'Minuman', 'Snack'];

        $existing = static::distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->toArray();

        return collect(array_merge($defaults, $existing))
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }
}
