<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SizeController;


Route::controller(SizeController::class)->prefix('size')->group(function () {
    Route::get('/list', 'list')->name('size.list');
    Route::get('/add', 'add')->name('size.add');
    Route::post('/store', 'store')->name('size.store');
    Route::get('/edit/{id}', 'edit')->name('size.edit');
    Route::put('/update/{id}', 'update')->name('size.update');
    Route::delete('/delete/{id}', 'delete')->name('size.delete');
});