<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAndUpdatedBy;

class Size extends Model
{
    use HasFactory, CreatedAndUpdatedBy;

    protected $table = 'sizes';

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

}
