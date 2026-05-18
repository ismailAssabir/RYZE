<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index() { return view('frontend.wishlist', ['items' => auth()->user()->wishlist()->with('product.images')->get()]); }
    public function toggle(Product $product) { Wishlist::firstOrCreate(['user_id' => auth()->id(), 'product_id' => $product->id]); return back(); }
    public function destroy(Wishlist $wishlist) { $wishlist->delete(); return back(); }
}
