<?php

use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

/* Slider */
Route::controller(SliderController::class)->prefix('slider')->group(function () {
    Route::get('/list', 'list')->name('slider.list')->can('list-slider');
    Route::get('/add', 'add')->name('slider.add')->can('add-slider');
    Route::post('/store', 'store')->name('slider.store');
    Route::get('/edit/{id}', 'edit')->name('slider.edit')->can('edit-slider');
    Route::put('/update/{id}', 'update')->name('slider.update');
    Route::delete('/delete/{id}','delete')->name('slider.delete')->can('delete-slider');
});