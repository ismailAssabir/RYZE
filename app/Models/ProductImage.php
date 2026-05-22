<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
protected $fillable = ['product_id', 'path', 'image', 'alt', 'is_primary', 'sort_order'];

    protected $appends = ['path'];
    protected $casts = ['is_primary' => 'boolean'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    /**
     * Normalise DB column differences (some migrations use `path`, others `image`).
     */
    public function getPathAttribute($value): ?string
    {
        if ($value) {
            return $value;
        }

        // fallback if schema uses `image`
        return $this->attributes['image'] ?? null;
    }
}

