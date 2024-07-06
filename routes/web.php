<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\AuthController;
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
Route::middleware('auth.user')->group(function () {
    Route::prefix('admin')->group(function () {

    });
});


