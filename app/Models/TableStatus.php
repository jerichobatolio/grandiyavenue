<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableStatus extends Model
{
    protected $fillable = [
        'table_number',
        'status',
        'seat_capacity',
        'description'
    ];

    protected $casts = [
        'seat_capacity' => 'integer',
    ];
}
