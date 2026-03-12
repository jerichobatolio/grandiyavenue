<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'bundle_price',
        'image',
        'category_id',
        'subcategory_id',
        'is_active'
    ];

    protected $casts = [
        'bundle_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'bundle_food')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Get total individual price of all foods in bundle
    public function getTotalIndividualPriceAttribute()
    {
        return $this->foods->sum(function ($food) {
            return $food->price * $food->pivot->quantity;
        });
    }

    // Get savings amount
    public function getSavingsAttribute()
    {
        return $this->total_individual_price - $this->bundle_price;
    }

    // Get savings percentage
    public function getSavingsPercentageAttribute()
    {
        if ($this->total_individual_price == 0) return 0;
        return round(($this->savings / $this->total_individual_price) * 100, 2);
    }
}
