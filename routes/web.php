<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HarvestPoolController;
use App\Http\Controllers\CommodityPriceController;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/komoditas', [CommodityPriceController::class, 'index'])->name('commodity.index');

Route::middleware(['auth', 'role:petani'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petani.dashboard');
    })->name('dashboard');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::patch('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('harvest-pools', HarvestPoolController::class)->only(['index', 'show', 'store']);
    Route::post('/harvest-pools/{harvestPool}/join', [HarvestPoolController::class, 'join'])->name('harvest-pools.join');
});

Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
