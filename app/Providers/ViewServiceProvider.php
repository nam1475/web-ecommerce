<?php
 
namespace App\Providers;

use App\Http\View\Composers\CartComposer;
use App\Http\View\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
 
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Truy cập đến và truyền data trong Composer(Mặc định data được truyền đi sẽ ở trong 
        function compose) vào view */
        View::composer('shop.layout.header', MenuComposer::class);
        // View::composer('shop.cart.list', CartComposer::class);
    }
}