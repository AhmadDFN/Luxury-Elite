<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'owner',
            'admin',
            'coach',
            'captain',
            'player',
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'slug' => Str::slug($role)
                ],
                [
                    'name' => ucfirst($role),
                    'slug' => Str::slug($role),
                ]
            );
        }
    }
}
