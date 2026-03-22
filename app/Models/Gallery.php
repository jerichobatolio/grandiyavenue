<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Public URL for the stored image. Gallery files use a named route that streams
     * from Storage (see GalleryController::serveImage) — same pattern as profile photos
     * and payment proofs — so hosting works without a working public/storage symlink
     * (common on Railway/Docker). Falls back to asset() for legacy paths.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        $path = str_replace('\\', '/', (string) $this->image_path);
        $path = ltrim($path, '/');

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        if (str_starts_with($path, 'gallery_images/')) {
            $filename = substr($path, strlen('gallery_images/'));
            if ($filename !== '') {
                return route('gallery.image', ['filename' => $filename], absolute: true);
            }
        }

        return asset('storage/'.$path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
