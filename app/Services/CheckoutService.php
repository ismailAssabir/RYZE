<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutService
{
    public function __construct(private CartService $cartService) {}

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $lines = $this->cartService->lines();
            abort_if($lines->isEmpty(), 422, 'Panier vide.');

            $totals = $this->cartService->totals();
            $discount = 0;
            if (! empty($data['coupon_code'])) {
                $coupon = Coupon::whereCode(strtoupper($data['coupon_code']))->first();
                if ($coupon?->isValidFor($totals['subtotal'])) {
                    $discount = $coupon->discountFor($totals['subtotal']);
                    $coupon->increment('used_count');
                }
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'number' => 'RYZ-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'],
                'subtotal' => $totals['subtotal'],
                'tax' => $totals['tax'],
                'shipping' => $totals['shipping'],
                'discount' => $discount,
                'total' => max(0, $totals['total'] - $discount),
                'coupon_code' => $data['coupon_code'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'billing_address' => $data['billing_address'] ?? $data['shipping_address'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $line->product_id,
                    'product_name' => $line->product->name,
                    'sku' => $line->product->sku,
                    'quantity' => $line->quantity,
                    'size' => $line->size,
                    'color' => $line->color,
                    'unit_price' => $line->unit_price,
                    'total' => $line->subtotal,
                ]);
                $line->product->decrement('stock', $line->quantity);
            }

            $lines->each->delete();

            return $order->load('items');
        });
    }
}
