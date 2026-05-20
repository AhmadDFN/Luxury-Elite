<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DivisionMember;
use App\Models\PlayerProfile;
use App\Models\PlayerTransferHistory;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama.
     */
    public function index()
    {
        // Hitung data untuk dashboard
        $stats = [
            'total_players'    => PlayerProfile::count(),
            'active_scrims'    => 3, // Nanti ganti dengan query Scrim asli
            'trial_players'    => DivisionMember::where('membership_status', 'trial')->count(),
            'recent_transfers' => PlayerTransferHistory::latest()->take(5)->get()->map(function ($h) {
                return [
                    'nickname' => $h->user->name ?? 'Unknown',
                    'from'     => $h->from_team,
                    'date'     => $h->created_at->diffForHumans()
                ];
            })
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats
        ]);
    }
}
