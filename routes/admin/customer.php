<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController;

/* Customer */
Route::controller(CustomerController::class)->prefix('customer')->group(function () {
    Route::get('/list', 'list')->name('customer.list')->can('list-customer');
    Route::delete('/delete/{id}','delete')->name('customer.delete')->can('delete-customer');
});
