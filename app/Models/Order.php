<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'title',
        'price',
        'quantity',
        'image',
        'delivery_status',
        'payment_mode',
        'notes',
        'payment_proof_path',
        'is_archived',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relationship with ReturnRefund
    public function returnRefunds()
    {
        return $this->morphMany(ReturnRefund::class, 'refundable');
    }

    // Check if order has active return/refund request
    public function hasActiveReturnRefund()
    {
        return $this->returnRefunds()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }
}
