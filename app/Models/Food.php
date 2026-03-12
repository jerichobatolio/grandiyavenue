<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food'; // make sure this matches your table name
    protected $fillable = ['title','detail','price','bundle_price','type','subcategory','image','category_id','subcategory_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Bundle::class, 'bundle_food')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Check if this food belongs to any bundle
    public function isInBundle(): bool
    {
        return $this->bundles()->exists();
    }

    // Get the first bundle this food belongs to (for display purposes)
    public function getFirstBundleAttribute()
    {
        return $this->bundles()->first();
    }
}