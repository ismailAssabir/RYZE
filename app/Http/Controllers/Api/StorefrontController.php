<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ReviewResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function cart(CartService $cart) { return response()->json(['items' => $cart->lines(), 'totals' => $cart->totals()]); }
    public function addToCart(Request $request, Product $product, CartService $cart) { return response()->json($cart->add($product, $request->all()), 201); }
    public function checkout(CheckoutRequest $request, CheckoutService $checkout) { return new OrderResource($checkout->createOrder($request->validated())); }
    public function orders() { return OrderResource::collection(auth()->user()->orders()->latest()->paginate(10)); }
    public function order(Order $order) { return new OrderResource($order->load('items')); }
    public function review(ReviewRequest $request, Product $product) { return new ReviewResource($product->reviews()->create($request->validated() + ['user_id' => auth()->id()])); }
}
