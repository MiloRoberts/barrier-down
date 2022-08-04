<?php

use App\Models\Game;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('games', [
        'games' => Game::all()
    ]);
});

Route::get('games/{game}', function (Game $game) {

    return view('game', [
        'game' => $game
    ]);
});

Route::get('consoles/{console}', function (Console $console) {
    return view('games', [
        'games' => $console->games
    ]);
});

// NOTE: Remember to make About page visible to non-logged in users 