<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table ='roles';
    protected $fillable = [
        'name',
        'display_name'
    ];
    // public $timestamps = false;

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')->withTimestamps();
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id')->withTimestamps();
    }

}
