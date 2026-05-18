<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Player\CreatePlayerAction;
use App\Http\Requests\StorePlayerRequest;

class PlayerController extends Controller
{
    public function index()
    {
        $players = PlayerProfile::query()

            ->select('player_profiles.*')

            ->join('users', 'users.id', '=', 'player_profiles.user_id')

            ->join(
                'division_members',
                'division_members.user_id',
                '=',
                'users.id'
            )

            ->with([
                'user',
                'user.divisionMemberships.role',
                'user.divisionMemberships.division',
                'gameRoles',
            ])

            ->orderBy('division_members.role_id', 'asc')

            ->latest('player_profiles.created_at')

            ->get();
        return Inertia::render('dashboard/players/Index', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Players/Create');
    }

    public function store(StorePlayerRequest $request)
    {
        app(CreatePlayerAction::class)
            ->handle($request->validated());

        return redirect()
            ->route('dashboard.players.index')
            ->with('success', 'Player created successfully');
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
