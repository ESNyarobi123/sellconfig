<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'config_id',
        'payment_order_id',
        'payment_phone',
        'amount',
        'net_amount',
        'fee_amount',
        'payment_status',
        'order_status',
        'paid_at',
        'delivered_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the user who made this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan for this order
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the config delivered with this order
     */
    public function config(): BelongsTo
    {
        return $this->belongsTo(Config::class);
    }

    /**
     * Check if order is pending payment
     */
    public function isPending(): bool
    {
        return $this->payment_status === 'pending' || $this->payment_status === 'processing';
    }

    /**
     * Check if order is completed
     */
    public function isCompleted(): bool
    {
        return $this->payment_status === 'completed' && $this->order_status === 'delivered';
    }

    /**
     * Mark order as paid and deliver config
     */
    public function deliverConfig(): bool
    {
        if ($this->config_id) {
            return true; // Already delivered
        }

        $config = Config::claimForUser($this->plan_id, $this->user_id);

        if (!$config) {
            return false; // No available configs
        }

        $this->update([
            'config_id' => $config->id,
            'order_status' => 'delivered',
            'delivered_at' => now(),
        ]);

        return true;
    }

    /**
     * Scope for user's completed orders
     */
    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }
}
