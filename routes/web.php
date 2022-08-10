<?php

use App\Models\Game;
use App\Models\GameConsole;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
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
        'games' => Game::with('game_console', 'game_title', 'game_console.console_manufacturer', 'game_console.console_name')
            ->get()
            ->sortBy('game_title.english_title')
        // ->sortBy('game_title') // I think I need JOIN for this to work
        // below makes unnecessary extra queries (see clockwork app)
        // 'games' => Game::all()
    ]);
});

// // Ben did it this way.
// Route::get('/', function () {
//     $g = Game::with('game_console', 'game_title', 'game_console.console_manufacturer', 'game_console.console_name')
//         ->get()
//         ->sortBy('game_title.english_title'); 
//         //dd($g[0]);
//     return view('games', ['games' => $g]
//         );
// });

Route::get('games/{game:slug}', function (Game $game) {

    return view('game', [
        'game' => $game
    ]);
});

Route::get('gameconsoles/{gameconsole:slug}', function (GameConsole $gameconsole) {
    // still have some redundancy below in queries (see clockwork app)
    // check out eager loading
    return view('games', [
        'games' => $gameconsole->games
    ]);
});

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');


// NOTE: Remember to make About page visible to non-logged in users

// NOTE: Don't forget to add caching