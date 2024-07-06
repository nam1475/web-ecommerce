<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UserController;
        
/* User */
Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('/list', 'list')->name('user.list')->can('list-user');
    Route::get('/add', 'add')->name('user.add')->can('add-user');
    Route::post('/store', 'store')->name('user.store');
    Route::get('/edit/{id}', 'edit')->name('user.edit')->can('edit-user');
    Route::put('/update/{id}', 'update')->name('user.update');
    Route::delete('/delete/{id}','delete')->name('user.delete')->can('delete-user');
    Route::get('/profile','profile')->name('user.profile');
});