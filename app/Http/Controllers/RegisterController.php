<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'password' =>  ['required','min:8','max:255']
            // 'password' =>  ['required','password','min:8','max:255'] // this not better?
        ]);

        // alternative to the eloquent mutator in User class
        // $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        auth()->login($user);

        return redirect('/')->with('success', 'Your account has been created.');
        // alternative to above
        // session()->flash('success', 'Your account has been created.');
        // return redirect('/');
    }
}
