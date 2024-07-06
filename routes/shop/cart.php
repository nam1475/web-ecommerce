<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopCartController;

Route::middleware('auth.customer')->group(function () {
    Route::controller(ShopCartController::class)->prefix('carts')->group(function () {
        Route::get('/list', 'list')->name('cart.list');
        Route::post('/add', 'add')->name('cart.add');      
        Route::post('/update', 'update')->name('cart.update');
        Route::get('/remove/{id}', 'remove')->name('cart.remove');
        Route::post('/list', 'addOrder')->name('cart.order');
    });
});