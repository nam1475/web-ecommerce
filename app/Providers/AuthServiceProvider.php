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

    }

    


}
