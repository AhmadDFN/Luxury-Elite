<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Player\CreatePlayerAction;
use App\Http\Requests\Dashboard\Player\StorePlayerRequest;
// use App\Http\Requests\StorePlayerRequest;
// use App\Models\Division;
// use App\Models\Role;
use Illuminate\Http\RedirectResponse;

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
