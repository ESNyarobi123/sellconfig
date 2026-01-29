<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Config extends Model
{
    protected $fillable = [
        'plan_id',
        'content',
        'status',
        'sold_to_user_id',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];

    /**
     * Get the plan this config belongs to
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the user who bought this config
     */
    public function soldToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_to_user_id');
    }

    /**
     * Atomically claim an available config for a user
     * This prevents race conditions where two users try to buy the same config
     */
    public static function claimForUser(int $planId, int $userId): ?self
    {
        return DB::transaction(function () use ($planId, $userId) {
            // Lock the row for update to prevent race conditions
            $config = self::where('plan_id', $planId)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (!$config) {
                return null;
            }

            $config->update([
                'status' => 'sold',
                'sold_to_user_id' => $userId,
                'sold_at' => now(),
            ]);

            return $config->fresh();
        });
    }

    /**
     * Scope for available configs
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for sold configs
     */
    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }
}
