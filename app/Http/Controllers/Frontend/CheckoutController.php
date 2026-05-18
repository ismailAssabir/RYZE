<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\PaymentService;

class CheckoutController extends Controller
{
    public function create(CartService $cart) { return view('frontend.checkout', ['lines' => $cart->lines(), 'totals' => $cart->totals()]); }

    public function store(CheckoutRequest $request, CheckoutService $checkout, PaymentService $payment)
    {
        $order = $checkout->createOrder($request->validated());
        $result = $payment->start($order);
        return $result['type'] === 'redirect' ? redirect($result['url'])->with('success', 'Commande confirmee.') : redirect()->route('orders.show', $order)->with('success', $result['message']);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('frontend.order', ['order' => $order->load('items')]);
    }
}
