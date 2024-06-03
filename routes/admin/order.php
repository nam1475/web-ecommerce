<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

/* Order */
Route::controller(OrderController::class)->prefix('customers')->group(function () {
    Route::get('/', 'listCustomer')->name('customer.list')->can('list-order');
    Route::get('/orders/{id}', 'customerOrderList')->name('order.detail')->can('edit-order');
    Route::put('/orders/update/{id}', 'updateStatus')->name('order.update');
    Route::delete('/delete/{id}', 'delete')->name('customer.delete')->can('delete-order');
});