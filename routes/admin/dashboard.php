<?php

use App\Http\Controllers\Admin\DashBoardController;
use Illuminate\Support\Facades\Route;

/* Dashboard */
Route::controller(DashBoardController::class)->prefix('dashboard')->group(function () {
    Route::get('/', 'index')->name('dashboard');
});