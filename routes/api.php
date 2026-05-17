<?php

use App\Http\Controllers\CommodityPriceController;
use App\Http\Controllers\HarvestPoolController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/commodity-prices', [CommodityPriceController::class, 'index'])->name('commodity-prices.index');
Route::get('/commodity-prices/{slug}', [CommodityPriceController::class, 'show'])->name('commodity-prices.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/harvest-pools', [HarvestPoolController::class, 'index'])->name('harvest-pools.index');
Route::get('/harvest-pools/{harvestPool}', [HarvestPoolController::class, 'show'])->name('harvest-pools.show');

Route::middleware(['auth', 'role:petani'])->group(function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');

    Route::post('/harvest-pools', [HarvestPoolController::class, 'store'])->name('harvest-pools.store');
    Route::post('/harvest-pools/{harvestPool}/join', [HarvestPoolController::class, 'join'])->name('harvest-pools.join');
});

Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});
