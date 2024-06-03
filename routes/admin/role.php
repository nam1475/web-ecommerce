<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/* Role */
Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('/list', 'list')->name('role.list')->can('list-role');
    Route::get('/add', 'add')->name('role.add')->can('add-role');
    Route::post('/store', 'store')->name('role.store');
    Route::get('/edit/{id}', 'edit')->name('role.edit')->can('edit-role');
    Route::put('/update/{id}', 'update')->name('role.update');
    Route::delete('/delete/{id}','delete')->name('role.delete')->can('delete-role');
});