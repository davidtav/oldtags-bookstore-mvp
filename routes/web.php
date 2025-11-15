<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('catalog.index');
});
Route::get('/cart', function () {
    return view('cart.index');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/admin/dashboard', function () {
    // Implemente a lógica de verificação de sessão Supabase aqui
    return view('admin.dashboard'); 
});