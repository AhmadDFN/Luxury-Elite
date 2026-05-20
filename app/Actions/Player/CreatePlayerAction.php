<?php

namespace App\Actions\Player;

use App\Models\DivisionHistory;
use App\Models\PlayerTransferHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreatePlayerAction
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // 1. Create Base User
            $user = User::create([
                'name' => $data['nickname'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(12)),
            ]);

            // 1.5 Handle File Upload (Simpan ke folder storage/app/public/players)
            $photoPath = null;
            $statsPhotoPath = null;

            // Gunakan request() untuk mengambil file karena array $data tidak bisa menampung instance UploadedFile secara default di beberapa versi Inertia
            if (request()->hasFile('photo')) {
                $photoPath = request()->file('photo')->store('players/photos', 'public');
            }
            if (request()->hasFile('stats_photo')) {
                $statsPhotoPath = request()->file('stats_photo')->store('players/stats', 'public');
            }

            // 2. Create Player Profile
            $profile = $user->playerProfile()->create([
                'real_name' => $data['real_name'],
                'nickname' => $data['nickname'],
                'uid_game' => $data['uid_game'],
                'whatsapp' => $data['whatsapp'] ?? null,
                'bio' => $data['bio'] ?? null,
                'photo' => $photoPath,
                'stats_photo' => $statsPhotoPath,
                'roster_visibility' => 'private' // default
            ]);

            // 3. Attach Division & Role
            $user->divisions()->attach($data['division_id'], [
                'role_id' => $data['role_id'],
                'membership_status' => $data['status'],
                'joined_at' => now(),
            ]);

            // Catat Transfer History (Jika toggle dicentang)
            if (!empty($data['record_history']) && $data['record_history'] == true) {
                PlayerTransferHistory::create([
                    'user_id' => $user->id,
                    'from_team' => $data['from_team'] ?: 'Free Agent',
                    'to_team' => $data['to_team'] ?: 'Luxury Elite',
                    'transfer_type' => 'in', // Karena ini form rekrutmen, otomatis statusnya "in"
                    'notes' => $data['history_notes'],
                    'recorded_by' => auth()->id(),
                ]);
            }

            // 4 & 5. Attach Game Roles & Vehicles
            if (!empty($data['selected_game_roles'])) {
                $profile->gameRoles()->sync($data['selected_game_roles']);
            }
            if (!empty($data['selected_vehicles'])) {
                $profile->vehicleSpecializations()->sync($data['selected_vehicles']);
            }

            return $user;
        });
    }
}
