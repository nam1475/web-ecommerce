<?php

use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

/* Permission */
Route::controller(PermissionController::class)->prefix('permission')->group(function () {
    Route::get('/list', 'list')->name('permission.list');
    Route::get('/add', 'add')->name('permission.add');
    Route::post('/store', 'store')->name('permission.store');
    Route::get('/edit/{id}', 'edit')->name('permission.edit');
    Route::put('/update/{id}', 'update')->name('permission.update');
    Route::delete('/delete/{id}','delete')->name('permission.delete');
});