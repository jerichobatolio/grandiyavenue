<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'guest', 
        'date',
        'time',
        'status',
        'table_number',
        'table_section',
        'time_in',
        'time_out',
        'duration_hours',
        'occasion',
        'special_requests',
        'user_id',
        'is_archived'
    ];
    
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];
}
