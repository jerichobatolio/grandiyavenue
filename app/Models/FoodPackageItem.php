<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPackageItem extends Model
{
    protected $fillable = [
        'name',
        'dishes',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}


