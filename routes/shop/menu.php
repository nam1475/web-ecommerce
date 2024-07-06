<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopMenuController;

Route::controller(ShopMenuController::class)->group(function () {
    Route::get('danh-muc/{slug}', 'index')->name('menu.list');
    Route::get('danh-muc/{slug}/filter', 'filterQueryString')->name('menu.filter');
});
