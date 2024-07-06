<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopCustomerController;

Route::middleware('auth.customer')->group(function () {
    Route::controller(ShopCustomerController::class)->prefix('account')->group(function () {
        Route::get('/info', 'profileInfo')->name('profile.info');
        Route::get('/info/edit/{id}', 'profileInfoEdit')->name('profile.info.edit');
        Route::put('/password/update/{id}', 'profilePasswordUpdate')->name('profile.password.update');
        Route::put('/info/update/{id}', 'profileInfoUpdate')->name('profile.info.update');
        Route::get('/order', 'profileOrder')->name('profile.order');
        Route::put('/order/cancel/{id}', 'cancelOrder')->name('profile.order.cancel');
    });
});