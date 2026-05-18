<?php

namespace Database\Seeders;

use Database\Seeders\DummyPlayerSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            DivisionsSeeder::class,
            GameRolesSeeder::class,
            VehicleSpecializationsSeeder::class,
            AdminUserSeeder::class,
            DummyPlayerSeeder::class,
        ]);
    }
}
