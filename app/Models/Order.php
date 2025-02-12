<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'address',
        'email',
        'content',
        'status'
    ];

    public function orderProducts(){
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
