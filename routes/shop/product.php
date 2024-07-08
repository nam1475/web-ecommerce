<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopProductController;

Route::get('product/{slug}', [ShopProductController::class, 'index'])->name('product.detail');
