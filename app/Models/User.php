<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use App\Models\Division;
use App\Models\DivisionMember;
use App\Models\PlayerTransferHistory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function hasRole($role): bool
    {
        return $this->divisionMemberships()
            ->whereHas('role', function ($query) use ($role) {
                $query->where('slug', $role);
            })
            ->exists();
    }

    public function isOwner(): bool
    {
        return $this->hasRole('owner');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isCoach(): bool
    {
        return $this->hasRole('coach');
    }

    public function isCaptain(): bool
    {
        return $this->hasRole('captain');
    }

    public function isPlayer(): bool
    {
        return $this->hasRole('player');
    }

    public function divisions()
    {
        return $this->belongsToMany(
            Division::class,
            'division_members'
        )->withPivot([
            'role_id',
            'membership_status',
            'joined_at'
        ])->withTimestamps();
    }

    public function divisionMemberships()
    {
        return $this->hasMany(DivisionMember::class);
    }

    public function transferHistories()
    {
        return $this->hasMany(PlayerTransferHistory::class, 'user_id');
    }
}
