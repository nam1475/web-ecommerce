<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopMainController;

Route::controller(ShopMainController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::post('/services/load-product', 'loadProduct')->name('loadProduct');
});