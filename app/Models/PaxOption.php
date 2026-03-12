<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaxOption extends Model
{
    protected $fillable = [
        'label',
        'value',
        'down_payment',
        'full_price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'integer',
        'down_payment' => 'decimal:2',
        'full_price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}


