<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'inclusions',
        'venue_type',
        'guest_number',
        'food_package',
        'down_payment',
        'price',
        'qr_code_image',
        'admin_photo',
        'is_active'
    ];

    protected $casts = [
        'down_payment' => 'decimal:2',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'inclusions' => 'array',
    ];

    public function timeSlots()
    {
        return $this->hasMany(EventTypeTimeSlot::class)->orderBy('sort_order');
    }

    // Scope for active event types
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted down payment
    public function getFormattedDownPaymentAttribute()
    {
        return '₱' . number_format($this->down_payment, 2);
    }

    // Accessor for formatted price
    public function getFormattedPriceAttribute()
    {
        return '₱' . number_format($this->price, 2);
    }

    // Get QR code image URL
    public function getQrCodeImageUrlAttribute()
    {
        return $this->qr_code_image ? \Storage::url($this->qr_code_image) : null;
    }

    // Get admin photo URL
    public function getAdminPhotoUrlAttribute()
    {
        return $this->admin_photo ? \Storage::url($this->admin_photo) : null;
    }

    // Get down payment percentage (safe from division by zero)
    public function getDownPaymentPercentageAttribute()
    {
        if ($this->price > 0) {
            return number_format(($this->down_payment / $this->price) * 100, 1);
        }
        return 0;
    }

    // Get remaining balance (safe calculation)
    public function getRemainingBalanceAttribute()
    {
        if ($this->price > 0) {
            return $this->price - $this->down_payment;
        }
        return 0;
    }

    // Get formatted remaining balance
    public function getFormattedRemainingBalanceAttribute()
    {
        if ($this->price > 0) {
            return '₱' . number_format($this->price - $this->down_payment, 2);
        }
        return 'N/A';
    }
}
