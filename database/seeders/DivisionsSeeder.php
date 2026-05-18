<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DivisionsSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            'WF Competitive',
            'OPS Competitive',
            'Luxury Elite Ladies',
            'Luxury Elite Casuals',
        ];

        foreach ($divisions as $division) {
            Division::updateOrCreate(
                [
                    'slug' => Str::slug($division)
                ],
                [
                    'name' => $division,
                    'slug' => Str::slug($division),
                    'description' => $division . ' Division',
                    'is_active' => true,
                ]
            );
        }
    }
}
