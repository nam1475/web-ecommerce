<?php

namespace App\Http\Services\GateAndPolicy;

use Illuminate\Support\Facades\Gate;

class pmsGateAndPolicy{
    public static function defineGates(){
        self::defineGateMenu();
        self::defineGateSlider();
        self::defineGateProduct();
    }

    public static function defineGateMenu(){
        /* Tham số callback(): Gọi tới các hàm trong MenuPolicy */
        Gate::define('list-menu', 'App\Policies\MenuPolicy@view');
        Gate::define('add-menu', 'App\Policies\MenuPolicy@create');
        Gate::define('edit-menu', 'App\Policies\MenuPolicy@edit');
        Gate::define('delete-menu', 'App\Policies\MenuPolicy@delete');
    }

    public static function defineGateSlider(){
        Gate::define('list-slider', 'App\Policies\SliderPolicy@view');
        Gate::define('add-slider', 'App\Policies\SliderPolicy@create');
        Gate::define('edit-slider', 'App\Policies\SliderPolicy@edit');
        Gate::define('delete-slider', 'App\Policies\SliderPolicy@delete');
    }

    public static function defineGateProduct(){
        Gate::define('list-product', 'App\Policies\ProductPolicy@view');
        Gate::define('add-product', 'App\Policies\ProductPolicy@create');
        Gate::define('edit-product', 'App\Policies\ProductPolicy@edit');
        Gate::define('delete-product', 'App\Policies\ProductPolicy@delete');
    }

    
}