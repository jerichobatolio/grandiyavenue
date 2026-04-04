<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Given name(s) for forms: registration stores all given names (e.g. "Willia Mae") in `name`
     * and the family name in `last_name`. Do not split `name` on the first space when `last_name` is set.
     */
    public function formGivenNameDefault(): string
    {
        $name = trim((string) $this->name);
        $last = trim((string) ($this->last_name ?? ''));

        if ($last !== '') {
            return $name;
        }

        $parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
        if (count($parts) >= 3) {
            return implode(' ', array_slice($parts, 0, -1));
        }

        return $name;
    }

    /**
     * Family name for forms; when `last_name` is empty, treat the last word of `name` as surname only if there are 3+ words.
     */
    public function formFamilyNameDefault(): string
    {
        $name = trim((string) $this->name);
        $last = trim((string) ($this->last_name ?? ''));

        if ($last !== '') {
            return $last;
        }

        $parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
        if (count($parts) >= 3) {
            return (string) $parts[count($parts) - 1];
        }

        return '';
    }

    /**
     * Full display name for checkout and similar (given + family).
     */
    public function fullDisplayName(): string
    {
        $first = trim((string) $this->name);
        $last = trim((string) ($this->last_name ?? ''));

        return $last === '' ? $first : trim($first.' '.$last);
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Use the named route that streams from Storage::disk('public') instead of
     * Storage::url(), so avatars work when public/storage is not symlinked
     * (same pattern as gallery images in this project).
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if (! $this->profile_photo_path) {
                return $this->defaultProfilePhotoUrl();
            }

            $url = route('user.profile.photo', ['user' => $this], absolute: false);
            $v = $this->updated_at?->timestamp;

            return $v !== null ? "{$url}?v={$v}" : $url;
        });
    }
}
