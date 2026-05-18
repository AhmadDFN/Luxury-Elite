<?php

namespace App\Actions\Player;

use App\Models\User;
use App\Models\PlayerProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreatePlayerAction
{
    public function handle(array $data): User
    {
        return DB::transaction(function () use ($data) {

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'name' => $data['nickname'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Player Profile
            |--------------------------------------------------------------------------
            */

            PlayerProfile::create([
                'user_id' => $user->id,
                'real_name' => $data['real_name'],
                'nickname' => $data['nickname'],
                'uid_game' => $data['uid_game'] ?? null,
                'roster_visibility' => 'private',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Attach Division & Role
            |--------------------------------------------------------------------------
            */

            $user->divisions()->attach([
                $data['division_id'] => [
                    'role_id' => $data['role_id'],
                    'membership_status' => 'active',
                    'joined_at' => now(),
                ]
            ]);

            return $user;
        });
    }
}
