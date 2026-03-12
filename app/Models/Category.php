<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'subtitle', 'emoji', 'image', 'is_active'];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

    public function bundles(): HasMany
    {
        return $this->hasMany(Bundle::class);
    }

    // Check if this category is a bundle package
    public function isBundlePackage(): bool
    {
        return strtolower($this->name) === 'bundle package';
    }
}
