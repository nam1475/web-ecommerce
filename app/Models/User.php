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

    public function checkPermissionAccess($user, $pmsCheck){
        /* Lấy ra id các roles của user hiện tại đang log in */
        $userRoles = Helper::getID($user->roles(), 'role_id');
        // dd($user->roles()->pluck('role_id'));
        foreach($userRoles as $ur){
            $role = Role::find($ur);
            /* Lấy ra id các permissions của roles thuộc user hiện tại */
            $rolePms = Helper::getID($role->permissions(), 'permission_id'); 
            // print_r($rolePms);

            /* Duyệt qua từng id permission và lấy ra từng bản ghi */
            foreach($rolePms as $rp){
                $permission = Permission::find($rp);

                /* So sánh 2 chuỗi ko phân biệt hoa thường, kiểm tra xem key code truyền vào có hợp lệ ko */
                if(strcasecmp($permission->key_code, $pmsCheck) == 0){
                    return true;
                }
            }
        }
        return false;
    }
}
