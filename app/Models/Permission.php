<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAndUpdatedBy;
use App\Traits\ParentAndChildrenRelationship;

class Permission extends Model
{
    use HasFactory, CreatedAndUpdatedBy, ParentAndChildrenRelationship;

    protected $table ='permissions';
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'active',
        'key_code'
    ];

    /* Quan hệ một nhiều giữa id và parent_id trong bảng permission */

    public function roles(){
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->withTimestamps();
    }
}
