<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Product $product)
    {
        $product->reviews()->updateOrCreate(['user_id' => auth()->id()], $request->validated() + ['is_approved' => false]);
        return back()->with('success', 'Avis envoye pour moderation.');
    }
}
