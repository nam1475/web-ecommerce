<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopMenuController;

Route::controller(ShopMenuController::class)->group(function () {
    Route::get('menu/{slug}', 'index')->name('menu.list');
    Route::get('menu/{slug}/filter-empty-query-string', 'filterEmptyQueryString')->name('menu.filter');
});
