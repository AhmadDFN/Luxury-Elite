<?php

namespace Database\Seeders;

use App\Models\VehicleSpecialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleSpecializationsSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            'MBT',
            'LT',
            'Helicopter',
            'Jet',
            'LAV-G1',
            'LAV-AA',
            'FSV',
            'Amphibi',
        ];

        foreach ($vehicles as $vehicle) {
            VehicleSpecialization::updateOrCreate(
                [
                    'slug' => Str::slug($vehicle)
                ],
                [
                    'name' => $vehicle,
                    'slug' => Str::slug($vehicle),
                ]
            );
        }
    }
}