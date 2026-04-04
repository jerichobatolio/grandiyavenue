<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Public URL for the stored QR image. Uses a named route that streams from
     * Storage::disk('public') so it works when /storage is not symlinked.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $url = route('admin.qr-code.image', ['adminQrCode' => $this], absolute: false);
        $v = $this->updated_at?->timestamp;

        return $v !== null ? "{$url}?v={$v}" : $url;
    }

    /**
     * Get the active global QR code
     */
    public static function getActiveGlobalQrCode()
    {
        return self::where('is_active', true)->first();
    }
}
