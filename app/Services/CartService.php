<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    public function lines(): Collection
    {
        return Cart::with('product.images')->where($this->owner())->get();

    }

    public function add(Product $product, array $data): Cart
    {
        return Cart::updateOrCreate(
            $this->owner() + ['product_id' => $product->id, 'size' => $data['size'] ?? null, 'color' => $data['color'] ?? null],
            ['quantity' => $data['quantity'] ?? 1, 'unit_price' => $product->final_price]
        );
    }

    public function update(Cart $cart, int $quantity): void
    {
        $cart->update(['quantity' => max(1, $quantity)]);
    }

    public function totals(): array
    {
        $subtotal = (float) $this->lines()->sum(fn ($line) => $line->subtotal);
        $tax = round($subtotal * 0.2, 2);
        $shipping = $subtotal > 1000 || $subtotal === 0.0 ? 0 : 49;

        return compact('subtotal', 'tax', 'shipping') + ['total' => $subtotal + $tax + $shipping];
    }

    private function owner(): array
    {
        // Migration 2026_05_15_000004 drops `session_id` from `carts`.
        // So we must scope carts only by user_id.
        // For guests, we persist cart rows with user_id = NULL.
        return auth()->check()
            ? ['user_id' => auth()->id()]
            : ['user_id' => null];
    }

}

