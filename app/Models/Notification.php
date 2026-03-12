<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Add all fields you want to mass assign here
    protected $fillable = [
        'user_id',
        'order_id',
        'event_booking_id',
        'type',
        'title',
        'message',
        'is_read',
        'data',
    ];

    // Optional: cast JSON fields
    protected $casts = [
        'data' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function eventBooking()
    {
        return $this->belongsTo(EventBooking::class);
    }
}
