<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAndUpdatedBy;

class Product extends Model
{
    use HasFactory, CreatedAndUpdatedBy;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb',
        'slug',
    ];

    public function menu(){
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

    public function sizes(){
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')->withTimestamps();
    }
    
}
