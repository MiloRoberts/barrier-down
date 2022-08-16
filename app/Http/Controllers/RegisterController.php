<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create() {
        return view('register.create');
    }

    public function store() {
        // NOTE: if validation fails, laravel will automatically redirect you
        $attributes = request()->validate([
            'name' =>  ['required','max:255'],
            'username' =>  ['required','min:3','max:255', 'unique:users,username'],
            // Rule::unique('users', 'username') can be used instead of 'unique:users,username' because it you can then use stuff like ->ignore() which can be useful when updating an account without triggering the unique restriction
            'email' =>  ['required','email','max:255', 'unique:users,email'],
            'password' =>  ['required','min:8','max:255'],
            // 'password' =>  ['required','password','min:8','max:255'] // this not better?
            'password' =>  ['required',    
                'required_with:retyped_password', 'same:retyped_password', 'min:8','max:255'],
            // maybe I don't need 'required' for above and/or below
            'retyped_password'
        ]);

        // alternative to the eloquent mutator in User class
        // $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        $this->insertGameUser();
        $this->insertLexemeUser();

        auth()->login($user);

        return redirect('/')->with('success', 'Your account has been created.');
        // alternative to above
        // session()->flash('success', 'Your account has been created.');
        // return redirect('/');
    }

    // consolidation needed since this exists elsewhere as well
    private function insertGameUser() {
        error_reporting(E_ERROR);
        try {
            $sqlQuery = "SELECT users.id, game_title_id, game_console_id FROM users, games;";
            $result = DB::select($sqlQuery);
            foreach($result as $row) {
                $sqlQuery = "INSERT IGNORE INTO games_users(`user_id`, game_id) VALUES('" . $row->id . "',(SELECT games.id FROM games WHERE game_title_id = '" . $row->game_title_id . "' AND game_console_id = '" . $row->game_console_id . "'));";
                $loopResult = DB::statement($sqlQuery);
            }
        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }

    // consolidation needed since this exists elsewhere as well
    private function insertLexemeUser() {
        error_reporting(E_ERROR);
        try {

            $sqlQuery = "SELECT users.id, lexeme_item_id, lexeme_meaning_id, lexeme_reading_id FROM users, lexemes;";
            $result = DB::select($sqlQuery);
            foreach($result as $row) {
                $sqlQuery = "INSERT IGNORE INTO lexemes_users(`user_id`, lexeme_id) VALUES('" . $row->id . "',(SELECT lexemes.id FROM lexemes WHERE lexeme_item_id = '" . $row->lexeme_item_id . "' AND lexeme_meaning_id = '" . $row->lexeme_meaning_id . "' AND lexeme_reading_id = '" . $row->lexeme_reading_id . "'));";
                $loopResult = DB::statement($sqlQuery);
            }

        } catch (Exception $exceptionError) {
            echo $exceptionError->getMessage();
        }
    }
}
