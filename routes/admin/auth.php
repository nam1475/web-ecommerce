<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UserAuthController;

Route::prefix('admin/user')->group(function () {
    Route::controller(UserAuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login/store', 'store')->name('login.store');
        Route::get('/logout', 'logout')->middleware('auth.user')->name('admin.user.logout');
        Route::get('/forgot-password', 'forgotPassword')->name('admin.user.forgot.password');
        Route::post('/forgot-password/action', 'forgotPasswordAction')->name('admin.user.forgot.password.action');
        Route::get('/reset-password/{token}', 'resetPassword')->name('admin.user.reset.password');
        Route::post('/reset-password/action/{token}', 'resetPasswordAction')->name('admin.user.reset.password.action'); 
    });
});