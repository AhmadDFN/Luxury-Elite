<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Player\CreatePlayerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Player\StorePlayerRequest;
use App\Models\PlayerProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    public function index()
    {
        $players = PlayerProfile::query()
            ->select('player_profiles.*')
            ->join('users', 'users.id', '=', 'player_profiles.user_id')
            ->join('division_members', 'division_members.user_id', '=', 'users.id')
            ->with([
                'user',
                'user.divisionMemberships.role',
                'user.divisionMemberships.division',
                'gameRoles',
            ])
            ->orderBy('division_members.role_id', 'asc')
            ->latest('player_profiles.created_at')
            ->groupBy('player_profiles.id') // Cegah duplikat jika 1 player beda divisi
            ->get()
            ->map(function ($profile) {
                $membership = $profile->user->divisionMemberships->first();

                // LOGIKA FOTO:
                // 1. Jika ada foto di database (misal kamu simpan nama file di kolom 'photo'), pakai URL-nya
                // 2. Jika tidak ada, kita generate foto avatar keren pakai UI-Avatars ber-tema gold
                $photoUrl = $profile->photo
                    ? asset('storage/' . $profile->photo) // Sesuaikan dengan setup storage Laravel kamu
                    : "https://ui-avatars.com/api/?name=" . urlencode($profile->nickname) . "&background=dca34f&color=111827&bold=true";

                return [
                    'id' => $profile->id,
                    'nickname' => $profile->nickname,
                    'real_name' => $profile->user->name ?? 'Unknown',
                    'uid_game' => $profile->uid_game,
                    'division' => $membership->division->name ?? 'Unassigned',
                    'role' => $membership->role->name ?? 'Unknown',

                    // Tambahkan field photo
                    'photo' => $photoUrl,
                ];
            });

        return Inertia::render('dashboard/players/Index', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return Inertia::render('dashboard/players/Create', [
            'divisions' => \App\Models\Division::select('id', 'name')->get(),
            'roles' => \App\Models\Role::select('id', 'name')->get(),
            // Kirim data master dari database
            'game_roles' => \App\Models\GameRole::select('id', 'name', 'slug')->get(),
            'vehicles' => \App\Models\VehicleSpecialization::select('id', 'name', 'slug')->get(),
        ]);
    }

    public function store(StorePlayerRequest $request, CreatePlayerAction $action): RedirectResponse
    {
        // 1. Validasi otomatis berjalan di StorePlayerRequest
        $validatedData = $request->validated();

        // 2. Lempar data yang sudah valid ke Action
        $action->execute($validatedData);

        // 3. Redirect ke halaman Index dengan Flash Message
        return redirect()->route('dashboard.players.index')
            ->with('message', 'Elite Player successfully recruited and added to the roster.');
    }

    /**
     * Display the specified resource (View Profile).
     */
    public function show(string $id)
    {
        // Ambil data user beserta relasinya yang lengkap
        $player = User::with([
            'playerProfile.gameRoles',
            'playerProfile.vehicleSpecializations',
            'divisions', // Untuk role & divisi aktif
            'transferHistories' => function ($query) {
                $query->latest('moved_at');
            }
        ])->findOrFail($id);

        return Inertia::render('dashboard/players/Show', [
            'player' => $player
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // PENTING: Tambahkan relasi bersarang agar data checkbox game & kendaraan ikut terbawa
        $player = User::with([
            'playerProfile.gameRoles',
            'playerProfile.vehicleSpecializations',
            'divisions'
        ])->findOrFail($id);

        return Inertia::render('dashboard/players/Edit', [
            'player' => $player,
            'divisions' => \App\Models\Division::select('id', 'name')->get(),
            'roles' => \App\Models\Role::select('id', 'name')->get(),
            'game_roles' => \App\Models\GameRole::select('id', 'name', 'slug')->get(),
            'vehicles' => \App\Models\VehicleSpecialization::select('id', 'name', 'slug')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Cari user yang akan di-edit
        $user = User::with('playerProfile')->findOrFail($id);

        // 2. Validasi data yang masuk dari Svelte Form
        $request->validate([
            'real_name'    => 'required|string|max:255',
            'nickname'     => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'whatsapp'     => 'nullable|string',
            'uid_game'     => 'nullable|string',
            'bio'          => 'nullable|string',
            'division_id'  => 'nullable|exists:divisions,id',
            'role_id'      => 'nullable|exists:roles,id',
            'status'       => 'required|string',
            'photo'        => 'nullable|image|max:2048',
            'stats_photo'  => 'nullable|image|max:2048',
        ]);

        // 3. Gunakan Database Transaction agar aman jika terjadi error di tengah jalan
        DB::transaction(function () use ($request, $user) {

            // A. Update Akun User Utama
            $user->update([
                'name'  => $request->nickname,
                'email' => $request->email,
                // 'role_id' => $request->role_id, // Aktifkan jika kolom role_id ada di tabel users
            ]);

            // B. Siapkan Data Profil Pemain
            $profileData = [
                'real_name' => $request->real_name,
                'nickname'  => $request->nickname,
                'uid_game'  => $request->uid_game,
                'whatsapp'  => $request->whatsapp,
                'bio'       => $request->bio,
            ];

            // C. Cek dan Proses Upload Jika Ada File Foto Baru (Avatar Pemain)
            if ($request->hasFile('photo')) {
                // Hapus foto lama di storage jika ada untuk menghemat ruang
                if ($user->playerProfile && $user->playerProfile->photo) {
                    Storage::disk('public')->delete($user->playerProfile->photo);
                }
                $profileData['photo'] = $request->file('photo')->store('players/photos', 'public');
            }

            // D. Cek dan Proses Upload Jika Ada File Foto Stats Baru
            if ($request->hasFile('stats_photo')) {
                if ($user->playerProfile && $user->playerProfile->stats_photo) {
                    Storage::disk('public')->delete($user->playerProfile->stats_photo);
                }
                $profileData['stats_photo'] = $request->file('stats_photo')->store('players/stats', 'public');
            }

            // E. Simpan Perubahan ke Tabel player_profiles
            $profile = $user->playerProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            // F. Sinkronisasi Checkbox (Game Roles & Vehicle Specializations)
            // Hubungan Many-to-Many akan otomatis diperbarui oleh method sync()
            if ($request->has('selected_game_roles')) {
                $profile->gameRoles()->sync($request->selected_game_roles);
            }

            if ($request->has('selected_vehicles')) {
                $profile->vehicleSpecializations()->sync($request->selected_vehicles);
            }

            // G. Perbarui Divisi Aktif (Tabel Pivot division_members)
            if ($request->division_id) {
                $user->divisions()->sync([
                    $request->division_id => [
                        'membership_status' => $request->status,
                        'joined_at'         => now(),
                    ]
                ]);
            } else {
                // Jika pilihan divisi dikosongkan, lepas pemain dari divisi mana pun
                $user->divisions()->detach();
            }
        });

        // 4. PENTING: Kembalikan redirect ke halaman Roster beserta Flash Message!
        // ->with('message', ...) inilah yang akan memicu Sonner Toast muncul secara otomatis
        return redirect('/dashboard/players')
            ->with('message', "Player '{$request->nickname}' tactical parameters updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Karena di migration kita menggunakan onDelete('cascade'), 
        // menghapus User otomatis menghapus Profile dan History-nya.
        $user->delete();

        return redirect('/dashboard/players')
            ->with('message', 'Elite Player successfully recruited and added to the roster.');
    }
}
