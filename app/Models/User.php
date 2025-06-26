<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * Get the user's favorite realties.
     */
    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    /**
     * Get the user's favorite realties as a collection of Realty models.
     */
    public function favoriteRealties()
    {
        return $this->belongsToMany(Realty::class, 'user_favorites', 'user_id', 'realty_id')
                    ->withTimestamps();
    }

    /**
     * Get the user's preferences.
     */
    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is a realtor
     *
     * @return bool
     */
    public function isRealtor(): bool
    {
        return $this->role === 'realtor';
    }

    /**
     * Check if the user is a moderator
     *
     * @return bool
     */
    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    /**
     * Check if the user is an administrator
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'administrator';
    }

    /**
     * Check if the user has moderator permissions (moderator or admin)
     *
     * @return bool
     */
    public function hasModeratorPermissions(): bool
    {
        return $this->isModerator() || $this->isAdmin();
    }
}
