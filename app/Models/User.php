<?php

/**
 * @property string $role
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'role',      // 'developer', 'client', 'admin'
        'password',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --------------------------
    // ROLE HELPERS
    // --------------------------

    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // --------------------------
    // PROFILE RELATIONSHIPS
    // --------------------------

    /**
     * Developer profile (freelancer profile)
     */
    public function developerProfile()
    {
        return $this->hasOne(Developer::class);
    }

    /**
     * Client profile
     */
    public function clientProfile()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the correct profile automatically based on role
     */
    public function profile()
    {
        if ($this->isDeveloper()) {
            return $this->developerProfile();
        } elseif ($this->isClient()) {
            return $this->clientProfile();
        }

        return null; // Admin or unassigned
    }

    // --------------------------
    // UTILITY METHODS
    // --------------------------

    /**
     * Check if user has a given role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}