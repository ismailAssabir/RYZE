<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function filtered(array $filters)
    {
        return Product::query()
            ->with(['category', 'brand', 'images'])
            ->withAvg('reviews', 'rating')
            ->visible()
            ->search($filters['q'] ?? null)
            ->when($filters['category'] ?? null, fn ($q, $v) => $q->whereRelation('category', 'slug', $v))
            ->when($filters['brand'] ?? null, fn ($q, $v) => $q->whereRelation('brand', 'slug', $v))
            ->when($filters['min'] ?? null, fn ($q, $v) => $q->where('price', '>=', $v))
            ->when($filters['max'] ?? null, fn ($q, $v) => $q->where('price', '<=', $v))
            ->when(($filters['sort'] ?? '') === 'price_asc', fn ($q) => $q->orderBy('price'))
            ->when(($filters['sort'] ?? '') === 'price_desc', fn ($q) => $q->orderByDesc('price'))
            ->when(($filters['sort'] ?? '') === 'popular', fn ($q) => $q->orderByDesc('is_popular'))
            ->latest()
            ->paginate(12)
            ->withQueryString();
    }

    public function homeCollections(): array
    {
        return [
            'featured' => Product::with('images')->visible()->where('featured', true)->take(8)->get(),
            'trending' => Product::with('images')->visible()->where('trending', true)->take(8)->get(),
            // mapping compat: 'popular' n'existe plus dans ton schéma ALTER (remplacer ensuite si besoin)
            'popular' => Product::with('images')->visible()->where('trending', true)->take(8)->get(),

        ];
    }
}
