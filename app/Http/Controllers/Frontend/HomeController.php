<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\PromotionBanner;
use App\Repositories\ProductRepository;

class HomeController extends Controller
{
    public function __invoke(ProductRepository $products)
    {
        return view('frontend.home', [
            ...$products->homeCollections(),
'categories' => Category::query()->take(8)->get(),
            'banner' => PromotionBanner::where('is_active', true)->latest()->first(),
            'posts' => Blog::where('is_published', true)->latest('published_at')->take(3)->get(),
        ]);
    }
}
