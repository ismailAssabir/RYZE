<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart) { return view('frontend.cart', ['lines' => $cart->lines(), 'totals' => $cart->totals()]); }

    public function store(Request $request, Product $product, CartService $cart)
    {
        $cart->add($product, $request->validate(['quantity' => 'nullable|integer|min:1|max:20', 'size' => 'nullable|string|max:20', 'color' => 'nullable|string|max:40']));
        return back()->with('success', 'Produit ajoute au panier.');
    }

    public function update(Request $request, Cart $cart, CartService $service)
    {
        $service->update($cart, (int) $request->validate(['quantity' => 'required|integer|min:1|max:20'])['quantity']);
        return back();
    }

    public function destroy(Cart $cart) { $cart->delete(); return back(); }
}
