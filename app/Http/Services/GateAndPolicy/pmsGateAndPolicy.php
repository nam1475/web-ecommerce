<?php

namespace App\Http\Services\GateAndPolicy;

use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Traits\HelperTrait;

class pmsGateAndPolicy{
    public static function defineGates(){
        /* Ko dùng được đoạn code ngắn hơn này do trong quá trình deploy lên server chưa có kết nối đến DB nên ko 
        thể truy vấn bảng permissions */
        // $pmsParents = HelperTrait::getParents(Permission::class);
        // foreach ($pmsParents as $pp){
        //     foreach($pp->children as $pc){
        //         /* Viết hoa chữ cái đtien trong những pms cha (product->Product) */
        //         $upperCaseName = ucfirst($pp->name); 
        //         /*
        //         - Hàm strtok() tách chuỗi thành các token dựa trên một tập hợp các ký tự phân tách. 
        //         - Chỉ lấy xâu kí tự đtien trong những pms con ('list product' -> 'list') */
        //         $firstWord = strtok($pc->name, ' ');
        //         /* '\\' trong chuỗi PHP đại diện cho một dấu \. */
        //         Gate::define($pc->key_code, "App\\Policies\\{$upperCaseName}Policy@{$firstWord}");
        //     }
        // }

        self::defineGateMenu();
        self::defineGateProduct();
        self::defineGateUser();
        self::defineGateRole();
        self::defineGatePermission();
        self::defineGateDashboard();
        self::defineGateCustomer();
        self::defineGateOrder();
        self::defineGateSlider();
        self::defineGateSize();
    }

    public static function defineGateMenu(){
        /* Tham số callback(): Gọi tới các hàm trong MenuPolicy */
        Gate::define('list-menu', 'App\Policies\MenuPolicy@list');  
        Gate::define('add-menu', 'App\Policies\MenuPolicy@add');
        Gate::define('edit-menu', 'App\Policies\MenuPolicy@edit');
        Gate::define('delete-menu', 'App\Policies\MenuPolicy@delete');
    }

    public static function defineGateProduct(){
        Gate::define('list-product', 'App\Policies\ProductPolicy@list');  
        Gate::define('add-product', 'App\Policies\ProductPolicy@add');
        Gate::define('edit-product', 'App\Policies\ProductPolicy@edit');
        Gate::define('delete-product', 'App\Policies\ProductPolicy@delete');
    }

    public static function defineGateUser(){
        Gate::define('list-user', 'App\Policies\UserPolicy@list');  
        Gate::define('add-user', 'App\Policies\UserPolicy@add');
        Gate::define('edit-user', 'App\Policies\UserPolicy@edit');
        Gate::define('delete-user', 'App\Policies\UserPolicy@delete');
    }

    public static function defineGateRole(){
        Gate::define('list-role', 'App\Policies\RolePolicy@list');  
        Gate::define('add-role', 'App\Policies\RolePolicy@add');
        Gate::define('edit-role', 'App\Policies\RolePolicy@edit');
        Gate::define('delete-role', 'App\Policies\RolePolicy@delete');
    }

    public static function defineGatePermission(){
        Gate::define('list-permission', 'App\Policies\PermissionPolicy@list');  
        Gate::define('add-permission', 'App\Policies\PermissionPolicy@add');
        Gate::define('edit-permission', 'App\Policies\PermissionPolicy@edit');
        Gate::define('delete-permission', 'App\Policies\PermissionPolicy@delete');
    }   

    public static function defineGateOrder(){
        Gate::define('list-order', 'App\Policies\OrderPolicy@list');  
        Gate::define('edit-order', 'App\Policies\OrderPolicy@edit');
        Gate::define('delete-order', 'App\Policies\OrderPolicy@delete');
    }

    public static function defineGateCustomer(){
        Gate::define('list-customer', 'App\Policies\CustomerPolicy@list');  
        Gate::define('edit-customer', 'App\Policies\CustomerPolicy@edit');
        Gate::define('delete-customer', 'App\Policies\CustomerPolicy@delete');
    }

    public static function defineGateDashboard(){
        Gate::define('list-dashboard', 'App\Policies\DashboardPolicy@list');
    }

    public static function defineGateSlider(){
        Gate::define('list-slider', 'App\Policies\SliderPolicy@list');  
        Gate::define('add-slider', 'App\Policies\SliderPolicy@add');
        Gate::define('edit-slider', 'App\Policies\SliderPolicy@edit');
        Gate::define('delete-slider', 'App\Policies\SliderPolicy@delete');
    }
    
    public static function defineGateSize(){
        Gate::define('list-size', 'App\Policies\SizePolicy@list');  
        Gate::define('add-size', 'App\Policies\SizePolicy@add');
        Gate::define('edit-size', 'App\Policies\SizePolicy@edit');
        Gate::define('delete-size', 'App\Policies\SizePolicy@delete');
    }




}