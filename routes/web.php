<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HarvestPoolController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommodityPriceController;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/komoditas', [CommodityPriceController::class, 'index'])->name('commodity.index');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware(['guest', 'throttle:5,1'])
    ->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:petani'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petani.dashboard');
    })->name('dashboard');
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::patch('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('harvest-pools', HarvestPoolController::class);
});

Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/harvest-pools/{harvest_pool}/join', [HarvestPoolController::class, 'join'])->name('harvest-pools.join');
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
