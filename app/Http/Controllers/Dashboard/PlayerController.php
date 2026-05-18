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
            ->with([
                'user',
                'user.divisionMemberships.role',
                'user.divisionMemberships.division',
                'gameRoles',
            ])
            ->latest()
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
