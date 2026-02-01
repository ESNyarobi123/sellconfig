<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'type', // weekly, bi_weekly, monthly
        'duration_days',
        'group_key',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($plan) {
            $plan->normalizeDuration();
        });
    }

    public function normalizeDuration()
    {
        // 1. Determine days based on type first (Explicit)
        if ($this->type === 'weekly') {
            $this->duration_days = 7;
        } elseif ($this->type === 'bi_weekly') {
            $this->duration_days = 14;
        } elseif ($this->type === 'monthly') {
            $this->duration_days = 30;
        }

        // If type didn't set it (fallback), keep existing or default
        if (!$this->duration_days) {
            $this->duration_days = 7;
        }

        // 2. Set strict group key
        if ($this->duration_days == 7) {
            $this->group_key = 'week_1';
        } elseif ($this->duration_days == 14) {
            $this->group_key = 'week_2';
        } elseif ($this->duration_days == 30) {
            $this->group_key = 'month_1';
        } else {
            $this->group_key = 'other';
        }
    }

    /**
     * Get configs for this plan
     */
    public function configs(): HasMany
    {
        return $this->hasMany(Config::class);
    }

    /**
     * Get available configs count
     */
    public function availableConfigsCount(): int
    {
        return $this->configs()->where('status', 'available')->count();
    }

    /**
     * Get sold configs count
     */
    public function soldConfigsCount(): int
    {
        return $this->configs()->where('status', 'sold')->count();
    }

    /**
     * Check if plan has stock
     */
    public function hasStock(): bool
    {
        return $this->availableConfigsCount() > 0;
    }

    /**
     * Get orders for this plan
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
