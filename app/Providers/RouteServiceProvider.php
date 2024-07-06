<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SessionGuard;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            /* namespace(): được sử dụng để chỉ định namespace cho các controller trong nhóm route này. 
            $this->namespace: Các controller trong nhóm này sẽ nằm trong namespace App\Http\Controllers 
            Laravel sẽ tải các route từ file
            */
            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/web.php'));
            
            /* Phải cần có thêm middleware 'web' nếu không xác thực(auth) mặc định sẽ không hoạt động khi session, 
            cookie,...(Được đky ở trong Kernel) chưa được bắt đầu: */
            $this->adminAuthRoute();
            Route::middleware(['web', 'auth.user'])->group(function () {
                Route::middleware(['session.guard:admin'])->prefix('admin')->group(function () {
                    $this->adminRoute();
                });
            });

            /* - Định nghĩa middleware session riêng cho từng trang admin và shop
            - Khi logout ở 1 trong 2 trang sẽ ko ảnh hưởng session ở trang còn lại */
            Route::middleware('session.guard:shop')->name('shop.')->group(function () {
                $this->shopRoute();
            });
        });
    }

    public function routePath($routePath){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path($routePath));
    }

    /* Tách các route ra file riêng và gọi đến thông qua base_path() */
    public function adminRoute(){
        $this->routePath('routes/admin/product.php');
        $this->routePath('routes/admin/menu.php');
        $this->routePath('routes/admin/slider.php');
        $this->routePath('routes/admin/order.php');
        $this->routePath('routes/admin/upload.php');
        $this->routePath('routes/admin/dashboard.php');
        $this->routePath('routes/admin/user.php');
        $this->routePath('routes/admin/role.php');
        $this->routePath('routes/admin/permission.php');
        $this->routePath('routes/admin/customer.php');
        $this->routePath('routes/admin/size.php');
    }

    public function adminAuthRoute(){
        $this->routePath('routes/admin/auth.php');
    }

    public function shopRoute(){
        $this->routePath('routes/shop/main.php');
        $this->routePath('routes/shop/cart.php');
        $this->routePath('routes/shop/menu.php');
        $this->routePath('routes/shop/product.php');
        $this->routePath('routes/shop/auth.php');
        $this->routePath('routes/shop/customer.php');
    }

    

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
