<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PlayerController;

Route::middleware(['auth'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        Route::resource('players', PlayerController::class);
    });

Route::get('/test-player', function () {

    $data = [

        'real_name' => 'Test Player',

        'nickname' => 'LXTest',

        'email' => 'testplayer@luxuryelite.gg',

        'password' => 'password123',

        'uid_game' => '123456789',

        'division_id' => 1,

        'role_id' => 5,

    ];

    app(\App\Actions\Player\CreatePlayerAction::class)
        ->handle($data);

    return 'Player Created';
});
