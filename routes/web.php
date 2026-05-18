<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{product:slug}', [ShopController::class, 'show'])->name('products.show');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/{page}', [PageController::class, 'simple'])->whereIn('page', ['about', 'contact', 'faq', 'categories'])->name('page');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister']);
    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendReset'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/email/verify', fn () => view('auth.verify-email'))->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', fn (EmailVerificationRequest $request) => tap($request->fulfill(), fn () => null) ?: redirect()->route('dashboard'))->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', fn (Request $request) => tap($request->user()->sendEmailVerificationNotification(), fn () => null) ?: back())->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [PageController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', InvoiceController::class)->name('orders.invoice');
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('orders', [AdminResourceController::class, 'orders'])->name('orders.index');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('users', AdminUserController::class);
    Route::get('reviews', [AdminResourceController::class, 'reviews'])->name('reviews.index');
    Route::get('coupons', [AdminResourceController::class, 'coupons'])->name('coupons.index');
    Route::get('analytics', [AdminResourceController::class, 'analytics'])->name('analytics');
    Route::get('settings', [AdminResourceController::class, 'settings'])->name('settings');
});
