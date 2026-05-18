<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\PlayerProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyPlayerSeeder extends Seeder
{
    public function run(): void
    {
        $players = [

            /*
            |--------------------------------------------------------------------------
            | OWNER
            |--------------------------------------------------------------------------
            */

            [
                'real_name' => 'Dany',
                'nickname' => 'iRzell',
                'uid_game' => '187384782094128993245',
                'role' => 'owner',
                'membership_status' => 'active',
                'division' => 'WF Competitive',
                'notes' => 'From Elite Esport to Luxury Elite',
            ],

            /*
            |--------------------------------------------------------------------------
            | TRIAL PLAYERS
            |--------------------------------------------------------------------------
            */

            [
                'real_name' => 'Rafi Alfaath Hakim',
                'nickname' => 'KEMATIAAANNNN',
                'uid_game' => '189590785627476426189',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Muhammad Syahid Habiburrahman',
                'nickname' => 'JURA | RIMURUUU',
                'uid_game' => '185313076966738981222',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Syahrizal',
                'nickname' => 'P1 | iOsB3DTR',
                'uid_game' => '45720240099654878051',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'MUHAMMAD IQBAL',
                'nickname' => 'UCILL99Z',
                'uid_game' => '186810885625637544999',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Riamar Sean Morgan',
                'nickname' => 'MORGAN1',
                'uid_game' => '188968791920992557439',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Nanda',
                'nickname' => 'PR1 | SEAN1',
                'uid_game' => '27480039657899551558',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Bayu Nugraha',
                'nickname' => 'PR1 | Morphy1',
                'uid_game' => '189950787763380382395',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Hani',
                'nickname' => 'Hani',
                'uid_game' => '45894414954707408147',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'fadli',
                'nickname' => 'LeRs',
                'uid_game' => '90009148224364351538',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'diki',
                'nickname' => 'KenxTo',
                'uid_game' => '36956265165826651239',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Apis',
                'nickname' => 'Forseze79',
                'uid_game' => '45450679633228757470',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Fik',
                'nickname' => 'TXDNR | JAYZ',
                'uid_game' => '36793790758866345883',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Junior',
                'nickname' => 'MAD | HutaooWi',
                'uid_game' => '27905323142996614475',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'Iyan',
                'nickname' => 'YoonahGOPUBLIK',
                'uid_game' => '81325621393692650756',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'afgan rangguci',
                'nickname' => 'F7 | Zyanno SEALVZ',
                'uid_game' => '182008142540938994879',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

            [
                'real_name' => 'ABID KHALIS BIN JUZAILI',
                'nickname' => 'FuZ1Hiroo',
                'uid_game' => '18809319972673724069',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
            ],

        ];

        foreach ($players as $player) {

            $email = strtolower(
                preg_replace('/[^a-zA-Z0-9]/', '', $player['nickname'])
            ) . '@luxuryelite.gg';

            $user = User::updateOrCreate(
                [
                    'email' => $email,
                ],
                [
                    'name' => $player['nickname'],
                    'password' => Hash::make('password'),
                ]
            );

            PlayerProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'real_name' => $player['real_name'],
                    'nickname' => $player['nickname'],
                    'uid_game' => $player['uid_game'],
                    'roster_visibility' => 'private',
                ]
            );

            $division = Division::where(
                'name',
                $player['division']
            )->first();

            $role = Role::where(
                'slug',
                $player['role']
            )->first();

            if ($division && $role) {

                $user->divisions()->syncWithoutDetaching([
                    $division->id => [
                        'role_id' => $role->id,
                        'membership_status' => $player['membership_status'],
                        'joined_at' => now(),
                    ]
                ]);
            }
        }
    }
}
