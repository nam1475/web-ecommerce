<?php

namespace App\Http\Services\GateAndPolicy;

use Illuminate\Support\Facades\Gate;

class pmsGateAndPolicy{
    public static function defineGates(){
        self::defineGateMenu();
        self::defineGateSlider();
        self::defineGateProduct();
        self::defineGateUser();
        self::defineGateRole();
        self::defineGatePermission();
        self::defineGateOrder();
        self::defineGateDashboard();
    }

    // public static function gate($action, $callback){
    //     return Gate::define($action, "App\Policies\$callback");
    // }

    public static function defineGateMenu(){
        /* Tham số callback(): Gọi tới các hàm trong MenuPolicy */
        Gate::define('list-menu', 'App\Policies\MenuPolicy@view');
        Gate::define('add-menu', 'App\Policies\MenuPolicy@create');
        Gate::define('edit-menu', 'App\Policies\MenuPolicy@edit');
        Gate::define('delete-menu', 'App\Policies\MenuPolicy@delete');
        // self::gate('list-menu', 'MenuPolicy');
        // self::gate('add-menu', 'MenuPolicy');
        // self::gate('edit-menu', 'MenuPolicy');
        // self::gate('delete-menu', 'MenuPolicy');
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

    public static function defineGateUser(){
        Gate::define('list-user', 'App\Policies\UserPolicy@view');
        Gate::define('add-user', 'App\Policies\UserPolicy@create');
        Gate::define('edit-user', 'App\Policies\UserPolicy@edit');
        Gate::define('delete-user', 'App\Policies\UserPolicy@delete');
    }

    public static function defineGateRole(){
        Gate::define('list-role', 'App\Policies\RolePolicy@view');
        Gate::define('add-role', 'App\Policies\RolePolicy@create');
        Gate::define('edit-role', 'App\Policies\RolePolicy@edit');
        Gate::define('delete-role', 'App\Policies\RolePolicy@delete');
    }

    public static function defineGatePermission(){
        Gate::define('list-permission', 'App\Policies\PermissionPolicy@view');
        Gate::define('add-permission', 'App\Policies\PermissionPolicy@create');
        Gate::define('edit-permission', 'App\Policies\PermissionPolicy@edit');
        Gate::define('delete-permission', 'App\Policies\PermissionPolicy@delete');
    }

    public static function defineGateOrder(){
        Gate::define('list-order', 'App\Policies\OrderPolicy@view');
        Gate::define('edit-order', 'App\Policies\OrderPolicy@edit');
        Gate::define('delete-order', 'App\Policies\OrderPolicy@delete');
    }

    public static function defineGateDashboard(){
        Gate::define('list-dashboard', 'App\Policies\DashboardPolicy@view');
    }

    
}