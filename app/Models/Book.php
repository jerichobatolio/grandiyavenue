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
        'down_payment_amount',
        'payment_option',
        'amount_paid',
        'payment_proof_path',
        'payment_confirmed_at',
        'gcash_reference_number',
        'gcash_transaction_id',
        'gcash_payment_date',
        'user_id',
        'is_archived'
    ];
    
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'down_payment_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'payment_confirmed_at' => 'datetime',
        'gcash_payment_date' => 'datetime',
    ];
}
