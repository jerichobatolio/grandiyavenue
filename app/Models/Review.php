<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'rating',
        'description',
        'headcount',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
        'headcount' => 'integer',
    ];

    // Scope to get only approved reviews
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Get star rating display
    public function getStarRatingAttribute()
    {
        $fullStars = str_repeat('★', $this->rating);
        $emptyStars = str_repeat('☆', 5 - $this->rating);
        return $fullStars . $emptyStars;
    }
}
