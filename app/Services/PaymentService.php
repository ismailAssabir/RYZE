<?php

namespace App\Services;

use App\Models\Order;

class PaymentService
{
    public function start(Order $order): array
    {
        if ($order->payment_method === 'cod') {
            $order->payment()->create([
                'provider' => 'cod',
                'status' => 'pending',
                'amount' => $order->total,
                'currency' => 'MAD',
            ]);

            return ['type' => 'redirect', 'url' => route('orders.show', $order)];
        }

        if ($order->payment_method === 'stripe') {
            return ['type' => 'external', 'provider' => 'stripe', 'message' => 'Configurez STRIPE_SECRET puis creez une session Stripe Checkout ici.'];
        }

        return ['type' => 'external', 'provider' => 'paypal', 'message' => 'Configurez PAYPAL_CLIENT_ID et PAYPAL_SECRET puis creez un ordre PayPal ici.'];
    }
}
