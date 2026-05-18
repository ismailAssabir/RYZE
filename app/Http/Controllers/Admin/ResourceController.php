<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;

class ResourceController extends Controller
{
    public function orders() { return view('admin.table', ['title' => 'Commandes', 'items' => Order::latest()->paginate(20)]); }
    public function categories() { return view('admin.table', ['title' => 'Categories', 'items' => Category::latest()->paginate(20)]); }
    public function users() { return view('admin.table', ['title' => 'Utilisateurs', 'items' => User::latest()->paginate(20)]); }
    public function reviews() { return view('admin.table', ['title' => 'Avis', 'items' => Review::with('product', 'user')->latest()->paginate(20)]); }
    public function coupons() { return view('admin.table', ['title' => 'Coupons', 'items' => Coupon::latest()->paginate(20)]); }
    public function analytics() { return view('admin.analytics', ['orders' => Order::selectRaw('DATE(created_at) as day, SUM(total) as total')->groupBy('day')->latest('day')->take(14)->get()]); }
    public function settings() { return view('admin.settings'); }
}
