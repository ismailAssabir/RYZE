<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductRepository $products) { return ProductResource::collection($products->filtered($request->all())); }
    public function show(Product $product) { return new ProductResource($product->load('category', 'brand', 'images')); }
}
