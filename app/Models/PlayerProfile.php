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
        'whatsapp',
        'bio',
        'photo',
        'stats_photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameRoles()
    {
        return $this->belongsToMany(GameRole::class, 'player_game_roles', 'player_profile_id', 'game_role_id');
    }

    public function vehicleSpecializations()
    {
        return $this->belongsToMany(VehicleSpecialization::class, 'player_vehicle_specializations', 'player_profile_id', 'vehicle_specialization_id');
    }
}
