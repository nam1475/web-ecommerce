<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAndUpdatedBy;

class Slider extends Model
{
    use HasFactory, CreatedAndUpdatedBy;
    protected $table ='sliders';
    protected $fillable = [
        'name',
        'url',
        'thumb',
        'sort_by',
        'active'
    ];

}
