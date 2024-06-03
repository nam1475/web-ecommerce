<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\AuthController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Shop\ShopMainController;
use App\Http\Controllers\Shop\ShopMenuController;
use App\Http\Controllers\Shop\ShopProductController;
use App\Http\Controllers\Shop\ShopCartController;
use Illuminate\Support\Facades\Artisan;

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

/* Auth */
// Route::controller(AuthController::class)->group(function () {
//     Route::get('admin/users/login', 'index')->name('login');
//     Route::post('admin/users/login/store', 'store')->name('login.store');
//     Route::get('/logout', 'logout')->middleware('auth')->name('logout');
// });

/* Admin */
/* Phân quyền:
- middelware: Sử dụng cho nhóm các route 
- gate, policy: Sử dụng riêng lẻ, cụ thể
*/
Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        
    });
});

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');

});


/* Shop */
// Route::controller(ShopAuthController::class)->group(function () {
//     Route::get('/register', 'register')->name('shop.register');
//     Route::post('/register', 'registerSave')->name('shop.register.save');

//     Route::get('/login', 'index')->name('shop.login');
//     Route::post('/login/store', 'store')->name('shop.login.store');
//     Route::get('shop/logout', 'logout')->middleware('auth')->name('shop.logout');
// });

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

