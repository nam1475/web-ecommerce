<?php

namespace App\Providers;

use App\Helpers\Helper;
use App\Http\Services\GateAndPolicy\pmsGateAndPolicy;
use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        /* Tách code ra class riêng và gọi đến phương thức này để define các gate */
        pmsGateAndPolicy::defineGates();

        /* $user: Lấy ra bản ghi của user hiện tại đăng nhập */
        Gate::define('admin', function ($user) {
            /* Lấy ra id các role của user hiện tại */
            $roles = Helper::getID($user->roles(), 'role_id');
            // dd($roles);
            foreach($roles as $cr){
                /* Lấy ra id các permission của role của user hiện tại */
                // $role = Role::find($cr);
                // $rolePms = Helper::getID($role->permissions(), 'permission_id'); 
                // foreach($rolePms as $rp){
                //     echo $rp . ' ';
                // }
                if($cr == 1){
                    return true;
                }
            }
            return false;
        });

        // Gate::define('product-list', function ($user) {
        //     return $user->checkPermissionAccess($user, 'product-list');
        // });

    }

    


}
