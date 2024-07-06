<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

/* Order */
Route::controller(OrderController::class)->prefix('order')->group(function () {
    Route::get('/', 'orderList')->name('order.list')->can('list-order');
    Route::get('/detail/{id}', 'orderDetail')->name('order.detail')->can('edit-order');
    Route::put('/update/{id}', 'updateStatus')->name('order.update');
    Route::delete('/delete/{id}', 'delete')->name('order.delete')->can('delete-order');
});