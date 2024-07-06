<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAndUpdatedBy;
use App\Traits\ParentAndChildrenRelationship;

class Menu extends Model
{
  use HasFactory, CreatedAndUpdatedBy, ParentAndChildrenRelationship;
  
  protected $table ='menus';
  protected $primaryKey = 'id';
  protected $fillable = [
    'id',
    'name',
    'parent_id',
    'description',
    'content',
    'active',
    'thumb',
    'slug'
  ];

  /* Một bản ghi trong bảng Menu có thể liên kết với nhiều bản ghi trong 
  bảng Product. */
  public function products(){
    return $this->hasMany(Product::class, 'menu_id', 'id');
  }

  

  


    

}
