<?php

use App\Http\Controllers\Admin\Users\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('admin/users/login', 'index')->name('login');
    Route::post('admin/users/login/store', 'store')->name('login.store');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});