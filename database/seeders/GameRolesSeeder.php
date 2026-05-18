<?php

namespace Database\Seeders;

use App\Models\GameRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameRolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Assault',
            'Recon',
            'Medic',
            'Engineer',
            'Vehicle',
        ];

        foreach ($roles as $role) {
            GameRole::updateOrCreate(
                [
                    'slug' => Str::slug($role)
                ],
                [
                    'name' => $role,
                    'slug' => Str::slug($role),
                ]
            );
        }
    }
}
