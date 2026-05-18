<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // IMPORTANT:
    // The last migration (2026_05_15_000004_alter_core_tables_to_match_schema.php)
    // drops the `session_id` column from `carts`.
    // So the model/fillable must not reference it.
    protected $fillable = ['user_id', 'product_id', 'quantity', 'size', 'color', 'unit_price'];

    protected $casts = ['unit_price' => 'decimal:2'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute(): float {
        return $this->quantity * (float) $this->unit_price;
    }
}

