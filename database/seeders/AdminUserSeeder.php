<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Division;
use App\Models\PlayerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@luxuryelite.gg'
            ],
            [
                'name' => 'Luxury Elite Admin',
                'password' => Hash::make('password'),
            ]
        );

        PlayerProfile::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'real_name' => 'Luxury Elite Admin',
                'nickname' => 'LXAdmin',
                'uid_game' => 'LX-0001',
                'whatsapp' => '08123456789',
                'roster_visibility' => 'private',
            ]
        );

        $division = Division::where('slug', 'wf-competitive')->first();

        $role = Role::where('slug', 'owner')->first();

        if ($division && $role) {
            $user->divisions()->syncWithoutDetaching([
                $division->id => [
                    'role_id' => $role->id,
                    'membership_status' => 'active',
                    'joined_at' => now(),
                ]
            ]);
        }
    }
}
