<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventBooking;
use App\Models\Order;

class ReturnRefund extends Model
{
    protected $fillable = [
        'user_id',
        'refundable_id',
        'refundable_type',
        'type',
        'status',
        'refund_amount',
        'reason',
        'admin_notes',
        'approval_image_path',
        'processed_at',
        'refund_method',
        'refund_reference',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // Polymorphic relationship - can belong to EventBooking or Order
    public function refundable()
    {
        return $this->morphTo();
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    public function scopeForEventBooking($query)
    {
        return $query->where('refundable_type', EventBooking::class);
    }

    public function scopeForOrder($query)
    {
        return $query->where('refundable_type', Order::class);
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    public function getFormattedRefundAmountAttribute()
    {
        return '₱' . number_format($this->refund_amount, 2);
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'refunded' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }
}
