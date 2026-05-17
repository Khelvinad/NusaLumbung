<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HarvestPoolController;
use App\Http\Controllers\CommodityPriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\PetaniController;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Marketplace
Route::get('/produk', [MarketplaceController::class, 'index'])->name('produk.index');
Route::get('/produk/{product}', [MarketplaceController::class, 'show'])->name('produk.show');
Route::get('/petani/{user}', [MarketplaceController::class, 'petani'])->name('petani.show');

Route::get('/komoditas', [CommodityPriceController::class, 'index'])->name('commodity.index');

Route::middleware(['auth', 'role:petani'])
    ->prefix('petani')
    ->name('petani.')
    ->group(function () {
        Route::get('/dashboard', [PetaniController::class, 'dashboard'])->name('dashboard');
        Route::get('/produk', [PetaniController::class, 'produkIndex'])->name('produk.index');
        Route::get('/produk/create', [PetaniController::class, 'produkCreate'])->name('produk.create');
        Route::post('/produk', [PetaniController::class, 'produkStore'])->name('produk.store');
        Route::get('/produk/{product}/edit', [PetaniController::class, 'produkEdit'])->name('produk.edit');
        Route::put('/produk/{product}', [PetaniController::class, 'produkUpdate'])->name('produk.update');
        Route::delete('/produk/{product}', [PetaniController::class, 'produkDestroy'])->name('produk.destroy');
        Route::patch('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
        Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::resource('harvest-pools', HarvestPoolController::class)->only(['index', 'show', 'store']);
        Route::post('/harvest-pools/{harvestPool}/join', [HarvestPoolController::class, 'join'])->name('harvest-pools.join');
    });

Route::middleware(['auth', 'role:pembeli'])
    ->prefix('pembeli')
    ->name('pembeli.')
    ->group(function () {
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';