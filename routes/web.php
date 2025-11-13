<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('catalog.index');
});
Route::get('/cart', function () {
    return view('cart.index');
});