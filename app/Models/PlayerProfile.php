<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'real_name',
        'nickname',
        'uid_game',
        'roster_visibility',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameRoles()
    {
        return $this->belongsToMany(
            GameRole::class,
            'player_game_roles'
        );
    }
}
