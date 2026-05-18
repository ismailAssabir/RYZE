<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'orders' => Order::latest()->take(8)->get(),
            'sales' => Order::count(),
            'users' => User::where('role', 'client')->count(),
            'products' => Product::count(),
            'lowStock' => Product::where('stock', '<=', 5)->get(),
        ]);
    }
}
