<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'is_active',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Scope to get only approved announcements
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope to get active and approved announcements for display
    public function scopeActiveAndApproved($query)
    {
        return $query->where('is_active', true)->where('status', 'approved');
    }
}
