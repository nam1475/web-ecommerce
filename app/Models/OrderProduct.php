<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table ='order_product';
    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'quantity',
        'price',
        'total',
    ];

    public function product(){
        return $this->hasOne(Product::class,'id', 'product_id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id', 'order_id');
    }

    public function size(){
        return $this->hasOne(Size::class,'id', 'size_id');
    }
}
