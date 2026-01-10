<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'canteen_id',
        'order_id',
        'content',
        'rating',
        'status',
        'response',
        'responded_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
            'rating' => 'integer',
        ];
    }

    /**
     * Status constants
     */
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIBACA = 'dibaca';
    const STATUS_DITANGGAPI = 'ditanggapi';

    /**
     * Get all possible statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DIBACA => 'Dibaca',
            self::STATUS_DITANGGAPI => 'Ditanggapi',
        ];
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'yellow',
            self::STATUS_DIBACA => 'blue',
            self::STATUS_DITANGGAPI => 'green',
            default => 'gray',
        };
    }

    /**
     * Get status label for UI
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? 'Unknown';
    }

    /**
     * Pembeli yang memberi feedback
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kantin yang diberi feedback
     */
    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    /**
     * Order terkait (optional)
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope untuk feedback menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    /**
     * Scope untuk feedback sudah dibaca
     */
    public function scopeDibaca($query)
    {
        return $query->where('status', self::STATUS_DIBACA);
    }

    /**
     * Scope untuk feedback sudah ditanggapi
     */
    public function scopeDitanggapi($query)
    {
        return $query->where('status', self::STATUS_DITANGGAPI);
    }

    /**
     * Mark feedback as read
     */
    public function markAsRead(): void
    {
        if ($this->status === self::STATUS_MENUNGGU) {
            $this->update(['status' => self::STATUS_DIBACA]);
        }
    }

    /**
     * Add response to feedback
     */
    public function addResponse(string $response): void
    {
        $this->update([
            'response' => $response,
            'status' => self::STATUS_DITANGGAPI,
            'responded_at' => now(),
        ]);
    }
}
