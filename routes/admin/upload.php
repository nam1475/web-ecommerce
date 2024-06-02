<?php

use App\Http\Controllers\Admin\UploadController;
use Illuminate\Support\Facades\Route;

/* Upload */
Route::post('/upload/services', [UploadController::class, 'store']);