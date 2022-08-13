<?php

namespace App\Http\Controllers;

// not using a request here so import is not required
// use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{

    // TO DO: add a means of resetting a forgotten password

    public function create() {
        return view('login.create');
    }

    public function destroy() {
        auth()->logout();

        // TO DO: add message and have disappear after set amount of time
        // return redirect('/')->with('success', 'Goodbye');
        return redirect('/')->with('success');
    }

    public function store() {
        // validate the request
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        // attempt to authenticate and log in the user based on the provided credentials
        // note that auth()->attempt() both signs the user in and confirms that the password is correct
        if (!auth()->attempt($attributes)) {
            // auth failed
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }
        
        // protect logged in user agaisnt session fixation attacks
        // more needed?
        session()->regenerate();
        // redirect with a success flash message
        // TO DO: add message and have disappear after set amount of time
        // return redirect('/')->with('success', 'Welcome back');
        return redirect('/')->with('success');

        // alternative to above
        // return back()
        //     ->withInput()
        //     ->withErrors(['email' => 'Your provided credentials could not be verified.']);        
    }
}
