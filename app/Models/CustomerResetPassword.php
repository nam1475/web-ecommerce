<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerResetPassword extends Model
{
    use HasFactory;

    protected $table = 'customer_password_resets';

    protected $fillable = [
        'email', 
        'token', 
    ];
    public $timestamps = false;
}
