<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminQrCode extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the URL for the QR code image
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /**
     * Get the active global QR code
     */
    public static function getActiveGlobalQrCode()
    {
        return self::where('is_active', true)->first();
    }
}
