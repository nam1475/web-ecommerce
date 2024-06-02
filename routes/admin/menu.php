<?php 

use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;

/* Menu */
Route::controller(MenuController::class)->prefix('menus')->group(function () {
    Route::get('/list', 'list')->name('menu.list')->can('list-menu');
    Route::get('/add', 'add')->name('menu.add')->can('add-menu');
    Route::post('/store', 'store')->name('menu.store');
    Route::get('/edit/{id}', 'edit')->name('menu.edit')->can('edit-menu');
    Route::put('/update/{id}', 'update')->name('menu.update');
    Route::delete('/delete/{id}', 'delete')->name('menu.delete')->can('delete-menu');
});