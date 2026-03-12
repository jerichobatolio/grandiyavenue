<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'detail',
        'price',
        'image',
        'quantity',
        'userid',
        'food_id',
        'bundle_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }

    // Check if this cart item is a bundle
    public function isBundle(): bool
    {
        return !is_null($this->bundle_id);
    }

    // Calculate total price for this cart item
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    // Get unit price (price per item)
    public function getUnitPriceAttribute()
    {
        return $this->price;
    }
}
