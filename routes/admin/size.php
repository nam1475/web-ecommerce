<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SizeController;

Route::controller(SizeController::class)->prefix('size')->group(function () {
    Route::get('/list', 'list')->name('size.list')->can('list-size');
    Route::get('/add', 'add')->name('size.add')->can('add-size');
    Route::post('/store', 'store')->name('size.store');
    Route::get('/edit/{id}', 'edit')->name('size.edit')->can('edit-size');
    Route::put('/update/{id}', 'update')->name('size.update');
    Route::delete('/delete/{id}', 'delete')->name('size.delete')->can('delete-size');
});