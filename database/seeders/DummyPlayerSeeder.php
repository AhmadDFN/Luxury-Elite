<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\PlayerProfile;
use App\Models\Role;
use App\Models\User;
use App\Models\GameRole;
use App\Models\VehicleSpecialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'game_roles' => ['Assault', 'Vehicle'],
                'vehicles' => ['Helicopter', 'MBT'],
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
                'game_roles' => ['Assault', 'Vehicle'],
                'vehicles' => ['LAV-G1', 'FSV'],
            ],

            [
                'real_name' => 'Muhammad Syahid Habiburrahman',
                'nickname' => 'JURA | RIMURUUU',
                'uid_game' => '185313076966738981222',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Recon', 'Vehicle'],
                'vehicles' => ['LAV-AA'],
            ],

            [
                'real_name' => 'Syahrizal',
                'nickname' => 'P1 | iOsB3DTR',
                'uid_game' => '45720240099654878051',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Medic', 'Engineer'],
                // Tidak ada vehicles karena tidak mengambil role 'Vehicle'
            ],

            [
                'real_name' => 'MUHAMMAD IQBAL',
                'nickname' => 'UCILL99Z',
                'uid_game' => '186810885625637544999',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Assault'],
                // Tidak ada vehicles
            ],

            [
                'real_name' => 'Riamar Sean Morgan',
                'nickname' => 'MORGAN1',
                'uid_game' => '188968791920992557439',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Assault', 'Vehicle'],
                'vehicles' => ['LT'],
            ],

            [
                'real_name' => 'Nanda',
                'nickname' => 'PR1 | SEAN1',
                'uid_game' => '27480039657899551558',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Recon', 'Vehicle'],
                'vehicles' => ['Helicopter', 'Jet'],
            ],

            [
                'real_name' => 'Bayu Nugraha',
                'nickname' => 'PR1 | Morphy1',
                'uid_game' => '189950787763380382395',
                'role' => 'player',
                'membership_status' => 'trial',
                'division' => 'WF Competitive',
                'game_roles' => ['Engineer', 'Vehicle'],
                'vehicles' => ['Amphibi', 'LAV-G1'],
            ],

            // Lanjutkan format ini untuk player lainnya jika ada
        ];

        foreach ($players as $player) {

            // 1. Create Base User
            $email = strtolower(
                preg_replace('/[^a-zA-Z0-9]/', '', $player['nickname'])
            ) . '@luxuryelite.gg';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $player['nickname'],
                    'password' => Hash::make('password'),
                ]
            );

            // 2. Create Player Profile
            $profile = PlayerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'real_name' => $player['real_name'],
                    'nickname' => $player['nickname'],
                    'uid_game' => $player['uid_game'],
                    'roster_visibility' => 'private',
                ]
            );

            // 3. Attach Division & System Role
            $division = Division::where('name', $player['division'])->first();
            $role = Role::where('slug', $player['role'])->first();

            if ($division && $role) {
                $user->divisions()->syncWithoutDetaching([
                    $division->id => [
                        'role_id' => $role->id,
                        'membership_status' => $player['membership_status'],
                        'joined_at' => now(),
                    ]
                ]);
            }

            // 4. Attach Game Roles
            // Karena tabel master sudah di-seed, kita cukup menggunakan where->first()
            if (isset($player['game_roles'])) {
                $gameRoleIds = [];
                foreach ($player['game_roles'] as $grName) {
                    // Gunakan firstOrCreate untuk safety, siapa tahu seedermu sebelumnya terlewat
                    $gr = GameRole::firstOrCreate(
                        ['name' => $grName],
                        ['slug' => Str::slug($grName)]
                    );
                    $gameRoleIds[] = $gr->id;
                }
                $profile->gameRoles()->syncWithoutDetaching($gameRoleIds);
            }

            // 5. Attach Vehicle Specializations
            // Validasi manual: Hanya attach vehicle jika user punya role 'Vehicle'
            if (isset($player['vehicles']) && in_array('Vehicle', $player['game_roles'])) {
                $vehicleIds = [];
                foreach ($player['vehicles'] as $vName) {
                    $vs = VehicleSpecialization::firstOrCreate(
                        ['name' => $vName],
                        ['slug' => Str::slug($vName)]
                    );
                    $vehicleIds[] = $vs->id;
                }
                $profile->vehicleSpecializations()->syncWithoutDetaching($vehicleIds);
            }
        }
    }
}