<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'minimum_amount', 'usage_limit', 'used_count', 'starts_at', 'expires_at', 'is_active'];
    protected $casts = ['value' => 'decimal:2', 'minimum_amount' => 'decimal:2', 'starts_at' => 'datetime', 'expires_at' => 'datetime', 'is_active' => 'boolean'];

    public function isValidFor(float $subtotal): bool
    {
        return $this->is_active
            && $subtotal >= (float) $this->minimum_amount
            && (! $this->expires_at || now()->lte($this->expires_at))
            && (! $this->usage_limit || $this->used_count < $this->usage_limit);
    }

    public function discountFor(float $subtotal): float
    {
        return $this->type === 'percent' ? round($subtotal * ((float) $this->value / 100), 2) : min($subtotal, (float) $this->value);
    }
}
