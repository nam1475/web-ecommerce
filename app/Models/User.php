<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    public function checkPermissionAccess($pmsCheck){
        /* Lấy ra id các roles của user hiện tại đang log in */
        $userRoles = auth()->user()->roles;
        // dd($userRoles);
        foreach($userRoles as $ur){
            /* Lấy ra id các permissions của roles thuộc user hiện tại */
            $rolePms = $ur->permissions; 
            // dd($rolePms);

            /* Kiểm tra $pmsCheck truyền vào có chứa key_code trong Collection hiện tại hay ko */
            if($rolePms->contains('key_code', $pmsCheck)){
                return true;
            }
        }
        return false;
    }
}
