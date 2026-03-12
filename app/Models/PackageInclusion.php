<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageInclusion extends Model
{
    protected $fillable = [
        'name',
        'pax_min',
        'pax_max',
        'price',
        'details',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}

