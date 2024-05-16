<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\AuthController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Shop\ShopMainController;
use App\Http\Controllers\Shop\ShopMenuController;
use App\Http\Controllers\Shop\ShopProductController;
use App\Http\Controllers\Shop\ShopCartController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('admin/users/login', 'index')->name('login');
    Route::post('admin/users/login/store', 'store')->name('login.store');
    Route::get('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(MainController::class)->group(function () {
            Route::get('/', 'index')->name('admin');
            Route::get('/main', 'index');
        });

        /* Menu */
        Route::controller(MenuController::class)->prefix('menus')->group(function () {
            Route::get('/list', 'list')->name('menu.list');
            Route::get('/add', 'add')->name('menu.add');
            Route::post('/store', 'store')->name('menu.store');
            Route::get('/edit/{id}', 'edit')->name('menu.edit');
            Route::put('/update/{id}', 'update')->name('menu.update');
            Route::delete('/delete/{id}', 'delete')->name('menu.delete');
        });

        /* Product */
        Route::controller(ProductController::class)->prefix('products')->group(function () {
            Route::get('/list', 'list')->name('product.list');
            Route::get('/add', 'add')->name('product.add');
            Route::post('/store', 'store')->name('product.store');
            Route::get('/edit/{id}', 'edit')->name('product.edit');
            Route::put('/update/{id}', 'update')->name('product.update');
            Route::delete('/delete/{id}', 'delete')->name('product.delete');
        });

        /* Upload */
        Route::post('/upload/services', [UploadController::class, 'store']);

        /* Slider */
        Route::controller(SliderController::class)->prefix('sliders')->group(function () {
            Route::get('/list', 'list')->name('slider.list');
            Route::get('/add', 'add')->name('slider.add');
            Route::post('/store', 'store')->name('slider.store');
            Route::get('/edit/{id}', 'edit')->name('slider.edit');
            Route::put('/update/{id}', 'update')->name('slider.update');
            Route::delete('/delete/{id}','delete')->name('slider.delete');
        });

        Route::controller(OrderController::class)->prefix('customers')->group(function () {
            Route::get('/', 'listCustomer')->name('customer.list');
            Route::get('/orders/{id}', 'listOrder')->name('order.detail');
            Route::delete('/delete/{id}', 'delete')->name('customer.delete');
        });
    });
});

Route::controller(ShopMainController::class)->group(function () {
    Route::get('/home', 'index')->name('shop.home');
    Route::post('/services/load-product', 'loadProduct')->name('shop.loadProduct');
});
    
Route::get('danh-muc/{id}-{slug}.html', [ShopMenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [ShopProductController::class, 'index']);

Route::controller(ShopCartController::class)->prefix('carts')->group(function () {
    Route::get('/list', 'list')->name('shop.cart.list');
    Route::post('/add', 'add')->name('shop.cart.add');      
    Route::post('/update', 'update')->name('shop.cart.update');
    Route::get('/remove/{id}', 'remove')->name('shop.cart.remove');
    Route::post('/list', 'addOrder')->name('shop.cart.order');
});

Route::get('orders/list', [OrderController::class, 'listOrder'])->name('shop.order.list');


