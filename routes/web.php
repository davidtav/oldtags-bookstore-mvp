<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

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

// Área Admin (ainda sem proteção)
Route::get('/admin/dashboard', function () {   
    return view('admin.dashboard'); 
});
