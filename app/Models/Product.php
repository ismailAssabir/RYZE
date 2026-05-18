<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'sale_price', 'stock', 'sizes', 'colors', 'attributes',
        'is_active', 'is_featured', 'is_trending', 'is_popular',
    ];

    protected $casts = [
        'price' => 'decimal:2', 'sale_price' => 'decimal:2',
        'sizes' => 'array', 'colors' => 'array', 'attributes' => 'array',
        'is_active' => 'boolean', 'is_featured' => 'boolean',
        'is_trending' => 'boolean', 'is_popular' => 'boolean',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function subcategory() { return $this->belongsTo(Subcategory::class, 'subcategory_id'); }
    public function brand() { return $this->belongsTo(Brand::class); }

    public function sizes() { return $this->hasMany(ProductSize::class); }
    public function colors() { return $this->hasMany(ProductColor::class); }

    public function images() { return $this->hasMany(ProductImage::class)->orderByDesc('is_primary'); }
    public function reviews() { return $this->hasMany(Review::class)->latest(); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getFinalPriceAttribute(): string
    {
        return $this->sale_price ?: $this->price;
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, fn ($q) => $q->where(fn ($s) => $s
            ->where('name', 'like', "%{$term}%")
            ->orWhere('sku', 'like', "%{$term}%")));
    }
}
