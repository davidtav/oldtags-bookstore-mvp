<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GoogleController;


// Página inicial → agora carrega via Controller
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');

// Carrinho
Route::get('/cart', function () {
    return view('cart.index');
});

// Login
Route::get('/login', function () {
    return view('auth.login');
});

// Autenticação via Google
Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
