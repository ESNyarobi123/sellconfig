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
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

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
