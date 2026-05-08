<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/produk', function () {
    return view('produk');
});

Route::get('/keranjang', function () {
    return view('keranjang');
});

require __DIR__.'/auth.php';

