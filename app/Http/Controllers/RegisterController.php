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
            'username' =>  ['required','min:3','max:255'],
            'email' =>  ['required','email','max:255'],
            'password' =>  ['required','min:8','max:255']
            // 'password' =>  ['required','password','min:8','max:255'] // this not better?
        ]);

        // alternative to the eloquent mutator in User class
        // $attributes['password'] = bcrypt($attributes['password']);

        User::create($attributes);
        
        return redirect('/');
    }
}
