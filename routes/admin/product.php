<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;

/* Product */
Route::controller(ProductController::class)->prefix('product')->group(function () {
    /* can(): Ủy quyền cho route cụ thể thông qua middleware, 'list-product' gọi tới tên của 
    Gate trong Gate:define */
    Route::get('/list', 'list')->name('product.list')->can('list-product');
    Route::get('/add', 'add')->name('product.add')->can('add-product');
    Route::post('/store', 'store')->name('product.store');
    Route::get('/edit/{id}', 'edit')->name('product.edit')->can('edit-product');
    Route::put('/update/{id}', 'update')->name('product.update');
    Route::delete('/delete/{id}', 'delete')->name('product.delete')->can('delete-product');
    Route::get('list/filter', 'filterQueryString')->name('product.list.filter');
});