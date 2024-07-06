<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopAuthController;

Route::controller(ShopAuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register/store', 'registerSave')->name('register.save');
    Route::get('/verify-account/{token}', 'checkVerifyAccount')->name('verify.account');    
    Route::get('/login', 'login')->name('login');
    Route::post('/login/action', 'loginAction')->name('login.action');
    Route::get('customer/logout', 'logout')->middleware('auth.customer')->name('logout');
    Route::post('/forgot-password', 'forgotPassword')->name('forgot.password');
    Route::get('/reset-password/{token}', 'resetPassword')->name('reset.password');
    Route::post('/reset-password/action/{token}', 'resetPasswordAction')->name('reset.password.action');
});