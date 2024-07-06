<?php

namespace App\Http\Services\GateAndPolicy;

use Illuminate\Support\Facades\Gate;
use App\Models\Permission;
use App\Traits\HelperTrait;

class pmsGateAndPolicy{
    public static function defineGates(){
        // $permissions = Permission::orderByRaw("SUBSTRING_INDEX(name, ' ', -1) asc")->paginate(15);
        $pmsParents = HelperTrait::getParents(Permission::class);
        foreach ($pmsParents as $pp){
            foreach($pp->children as $pc){
                /* Viết hoa chữ cái đtien trong những pms cha (product->Product) */
                $upperCaseName = ucfirst($pp->name); 
                /*
                - Hàm strtok() tách chuỗi thành các token dựa trên một tập hợp các ký tự phân tách. 
                - Chỉ lấy xâu kí tự đtien trong những pms con ('list product' -> 'list') */
                $firstWord = strtok($pc->name, ' ');
                /* '\\' trong chuỗi PHP đại diện cho một dấu \. */
                Gate::define($pc->key_code, "App\\Policies\\{$upperCaseName}Policy@{$firstWord}");
            }
        }
    }

    // public static function defineGateMenu(){
    //     /* Tham số callback(): Gọi tới các hàm trong MenuPolicy */
    //     Gate::define('list-menu', 'App\Policies\MenuPolicy@view');  
    //     Gate::define('add-menu', 'App\Policies\MenuPolicy@create');
    //     Gate::define('edit-menu', 'App\Policies\MenuPolicy@edit');
    //     Gate::define('delete-menu', 'App\Policies\MenuPolicy@delete');
    // }


    
}