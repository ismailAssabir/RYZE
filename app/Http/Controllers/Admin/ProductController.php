<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() { return view('admin.products', ['products' => Product::with('category', 'brand')->latest()->paginate(20)]); }
    public function create() { return view('admin.product-form', ['product' => new Product(), 'categories' => Category::all(), 'brands' => Brand::all()]); }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated() + ['slug' => Str::slug($request->name)]);

        $this->syncImagesFromRequest($request, $product);

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product) 
    { 
        return view('admin.show', [
            'item' => $product,
            'editRoute' => route('admin.products.edit', $product)
        ]); 
    }

    public function edit(Product $product)
    {
        return view('admin.product-form', ['product' => $product, 'categories' => Category::all(), 'brands' => Brand::all()]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated() + ['slug' => Str::slug($request->name)]);

        $this->syncImagesFromRequest($request, $product);

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product) { $product->delete(); return back(); }

    private function syncImagesFromRequest(ProductRequest $request, Product $product): void
    {
        // When admin uploads images[], we replace all existing images for this product.
        if (!$request->hasFile('images')) {
            return;
        }

        $request->validate([
            'images' => 'array',
        ]);

        $product->images()->delete();

        $files = $request->file('images', []);
        $altList = $request->input('images_alt', []);

        foreach ($files as $index => $file) {
            if (!$file) {
                continue;
            }

            $isPrimary = $index === 0;

            $path = $file->store('product-images', 'public');

            $product->images()->create([
                'path' => $path,
                'alt' => $altList[$index] ?? null,
                'is_primary' => $isPrimary,
                'sort_order' => $index,
            ]);
        }
    }
}

