<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTypeTimeSlot extends Model
{
    protected $fillable = [
        'event_type_id',
        'label',
        'start_time',
        'end_time',
        'details',
        'sort_order',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    /**
     * Display string for the time range (e.g. "10:00 AM - 2:00 PM" or "Whole Day")
     */
    public function getTimeRangeDisplayAttribute(): string
    {
        if ($this->start_time && $this->end_time) {
            return \Carbon\Carbon::parse($this->start_time)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($this->end_time)->format('g:i A');
        }
        return $this->label;
    }

    /**
     * Value for time input (HH:MM)
     */
    public function getStartTimeInputAttribute(): ?string
    {
        return $this->start_time ? substr($this->start_time, 0, 5) : null;
    }

    public function getEndTimeInputAttribute(): ?string
    {
        return $this->end_time ? substr($this->end_time, 0, 5) : null;
    }
}
