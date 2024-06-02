<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/* Role */
Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('/list', 'list')->name('role.list');
    Route::get('/add', 'add')->name('role.add');
    Route::post('/store', 'store')->name('role.store');
    Route::get('/edit/{id}', 'edit')->name('role.edit');
    Route::put('/update/{id}', 'update')->name('role.update');
    Route::delete('/delete/{id}','delete')->name('role.delete');
});