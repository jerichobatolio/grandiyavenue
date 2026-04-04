<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Rows the admin Notifications page (and bell badge) should show.
     * Hides in-app receipts meant only for customers (return/refund submit confirmation).
     */
    public function scopeVisibleOnAdminNotificationsPage(Builder $query): Builder
    {
        return $query
            ->whereNotIn('type', ['return_refund_submitted_customer'])
            ->where(function (Builder $q) {
                $q->where('title', '!=', 'Return/Refund Request Submitted')
                    ->orWhereNull('user_id');
            });
    }

    public static function unreadCountVisibleOnAdminNotificationsPage(): int
    {
        return static::query()
            ->visibleOnAdminNotificationsPage()
            ->where('is_read', false)
            ->count();
    }

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
