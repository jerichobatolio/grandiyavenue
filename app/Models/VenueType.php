<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];

    // Scope for active venue types
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted capacity
    public function getFormattedCapacityAttribute()
    {
        return $this->capacity ? $this->capacity . ' guests' : 'No limit';
    }
}
