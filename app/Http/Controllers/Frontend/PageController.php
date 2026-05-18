<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class PageController extends Controller
{
    public function dashboard() { return view('frontend.dashboard', ['orders' => auth()->user()->orders()->latest()->take(5)->get()]); }
    public function orders() { return view('frontend.orders', ['orders' => auth()->user()->orders()->latest()->paginate(10)]); }
    public function blog() { return view('frontend.blog', ['posts' => Blog::where('is_published', true)->latest('published_at')->paginate(9)]); }
    public function simple(string $page) { return view('frontend.simple', ['page' => $page]); }
}
