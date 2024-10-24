<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                return;
            } else {
                $user->reservations()->delete();
            }

            $emailParts = explode('@', $user->email);
            $domainParts = explode('.', $emailParts[1]);

            $newEmail = $emailParts[0] . '@' . $domainParts[0] . '.' . $domainParts[1] . '_soft_deleted_' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $user->email = $newEmail;
            $user->saveQuietly();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name2',
        'email',
        'phone',
        'password',
        'picture',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's reservations.
     *
     * @return HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function adminComments(): HasMany
    {
        return $this->hasMany(AdminComment::class);
    }
}
