<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'final_price' => $this->final_price,
            'stock' => $this->stock,
            'category' => $this->category?->name,
            'brand' => $this->brand?->name,
            'rating' => $this->average_rating,
            'images' => $this->images->pluck('path'),
        ];
    }
}
