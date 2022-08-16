<?php

use App\Models\Game;
use App\Models\GameConsole;
use App\Http\Controllers\FlashcardsController;
// use App\Http\Controllers\GamesController; //probably won't use after all
use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\ScreenshotsController; //probably won't use after all
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SpreadsheetsController;
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
    return view('index');
});

Route::get('games', function () {
    return view('games', [
        'games' => Game::with('game_console', 'game_title')
            ->get()
            ->sortBy('game_title.english_title')
            // note that it must use .english_title
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

Route::get('flashcards', function () {
    // return view('flashcards', [
        // 'userId' => Auth::user()->id
    // ]);
    return view('flashcards');
});
// Route::get('flashcards', [FlashcardsController::class, 'show'])->middleware('auth');

Route::get('settings', function () {
    // return view('settings', [
    //     'user_id'  => Auth::user()->id,
    //     'user_games' => GameUser::with('game_console', 'game_title')
    //         ->where('user_id', Auth::user()->id)
    //         ->get(),
    //     'user_lexemes' =>LexemeUser::with('lexeme_item', 'lexeme_meaning', 'lexeme_reading')
    //         ->where('user_id', Auth::user()->id)
    //         ->get()
    // ]);
    return view('settings');
});

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

// TO DO: have controller below handle spreadsheet uploads
Route::get('spreadsheet', [SpreadsheetsController::class, 'create'])->middleware('admin');
Route::post('spreadsheet', [SpreadsheetsController::class, 'store'])->middleware('admin');

Route::get('about', function() {
    return view('about');
});

// NOTE: Remember to make About page visible to non-logged in users

// NOTE: Don't forget to add caching