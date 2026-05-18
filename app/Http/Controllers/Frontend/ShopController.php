<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, ProductRepository $products)
    {
        return view('frontend.shop', [
            'products' => $products->filtered($request->all()),
'categories' => Category::query()->get(),
'brands' => Brand::query()->get(),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images', 'reviews.user']);

        return view('frontend.product', [
            'product' => $product,
            'related' => Product::with('images')->visible()->where('category_id', $product->category_id)->whereKeyNot($product->id)->take(4)->get(),
        ]);
    }
}
