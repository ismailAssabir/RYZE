<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product:slug}', [ProductController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/cart', [StorefrontController::class, 'cart']);
    Route::post('/cart/{product}', [StorefrontController::class, 'addToCart']);
    Route::post('/orders', [StorefrontController::class, 'checkout']);
    Route::get('/orders', [StorefrontController::class, 'orders']);
    Route::get('/orders/{order}', [StorefrontController::class, 'order']);
    Route::post('/products/{product}/reviews', [StorefrontController::class, 'review']);
});
