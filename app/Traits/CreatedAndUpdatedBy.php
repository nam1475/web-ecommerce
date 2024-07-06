<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

trait CreatedAndUpdatedBy
{
    public static function bootCreatedAndUpdatedBy()
    {
        static::creating(function ($model) {
            if (Auth::guard('web')->check()) {
                $model->created_by = auth()->user()->id;
                $model->updated_by = auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (Auth::guard('web')->check()) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public function userCreated(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated(){
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}