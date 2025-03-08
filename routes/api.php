<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarqueController;
Route::apiResource('marques', MarqueController::class);
//Route::get('marques/{id}', [MarqueController::class, 'show']);
// Public routes (no authentication required)
Route::prefix('v1')->group(function () {
    //Route::get('products', [ProductController::class, 'index']);
    //Route::get('categories', [CategoryController::class, 'index']);
});

// Client routes (client authentication required)
Route::prefix('v1')->middleware('keycloak:client')->group(function () {
    //Route::post('orders', [OrderController::class, 'store']);
    //Route::get('orders', [OrderController::class, 'index']);
    //Route::get('profile', [ProfileController::class, 'show']);
});

// Admin routes (admin authentication required)
Route::prefix('v1/admin')->middleware('keycloak:admin')->group(function () {
    //Route::apiResource('products', AdminProductController::class);
    //Route::apiResource('categories', AdminCategoryController::class);
    //Route::apiResource('orders', AdminOrderController::class);
    //Route::apiResource('users', AdminUserController::class);
});
