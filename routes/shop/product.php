<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopProductController;

Route::get('san-pham/{slug}', [ShopProductController::class, 'index'])->name('product.detail');
