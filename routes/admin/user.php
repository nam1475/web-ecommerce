<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UserController;

        
/* User */
Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('/list', 'list')->name('user.list');
    Route::get('/add', 'add')->name('user.add');
    Route::post('/store', 'store')->name('user.store');
    Route::get('/edit/{id}', 'edit')->name('user.edit');
    Route::put('/update/{id}', 'update')->name('user.update');
    Route::delete('/delete/{id}','delete')->name('user.delete');
});