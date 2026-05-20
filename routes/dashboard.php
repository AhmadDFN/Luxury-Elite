<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PlayerController;
use App\Http\Controllers\Dashboard\DivisionController; // Contoh nanti

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    // Hapus ->name('dashboard.') agar tidak jadi dashboard.index
    // Kita buat group agar route-nya tetap bersih
    ->group(function () {

        // Ubah name menjadi 'dashboard' agar cocok dengan import Sidebar
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Untuk resource, dia akan otomatis membuat dashboard.players.index, dsb
        Route::resource('players', PlayerController::class);

        // 3. Persiapan untuk fitur masa depan (Tinggal buat controllernya)
        // Route::resource('divisions', DivisionController::class);
        // Route::resource('scrims', ScrimController::class);
        // Route::resource('vods', VodController::class);
        // Route::resource('news', NewsController::class);
    });
