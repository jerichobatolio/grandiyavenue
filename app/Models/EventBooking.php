<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'contact_number',
        'email',
        'event_date',
        'time_in',
        'time_out',
        'number_of_guests',
        'additional_notes',
        'selected_food_items',
        'status',
        'down_payment_amount',
        'payment_option',
        'amount_paid',
        'payment_proof_path',
        'payment_confirmed_at',
        'gcash_reference_number',
        'gcash_transaction_id',
        'gcash_payment_date',
        'event_type_id',
        'venue_type_id',
        'package_inclusion_id',
        'is_archived'
    ];

    protected $casts = [
        'event_date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'selected_food_items' => 'array',
        'down_payment_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'gcash_payment_date' => 'datetime'
    ];

    // Scope for pending bookings
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    // Scope for paid bookings
    public function scopePaid($query)
    {
        return $query->where('status', 'Paid');
    }

    // Scope for cancelled bookings
    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }

    // Scope for upcoming events
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    // Scope for today's events
    public function scopeToday($query)
    {
        return $query->whereDate('event_date', now()->toDateString());
    }


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with EventType
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    // Relationship with VenueType
    public function venueType()
    {
        return $this->belongsTo(VenueType::class);
    }

    // Relationship with PackageInclusion
    public function packageInclusion()
    {
        return $this->belongsTo(PackageInclusion::class);
    }

    // Accessor for formatted event date
    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('F d, Y');
    }

    // Accessor for formatted down payment
    public function getFormattedDownPaymentAttribute()
    {
        return '₱' . number_format($this->down_payment_amount, 2);
    }

    public function getPaymentOptionLabelAttribute()
    {
        return match ($this->payment_option) {
            'full_payment' => 'Full Payment',
            'down_payment' => 'Down Payment',
            default => null,
        };
    }

    // Check if payment proof exists
    public function hasPaymentProof()
    {
        return !is_null($this->payment_proof_path);
    }

    // Get payment proof URL
    public function getPaymentProofUrlAttribute()
    {
        return $this->payment_proof_path ? \Storage::url($this->payment_proof_path) : null;
    }

    // Check if GCash payment details exist
    public function hasGcashPaymentDetails()
    {
        return !is_null($this->gcash_reference_number) && !is_null($this->gcash_transaction_id);
    }

    // Relationship with ReturnRefund
    public function returnRefunds()
    {
        return $this->morphMany(ReturnRefund::class, 'refundable');
    }

    // Check if booking has active return/refund request
    public function hasActiveReturnRefund()
    {
        return $this->returnRefunds()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
    }

}
