<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LexemesController extends Controller
{
    public function create() {

        return view('lexemes.create');
    }

    public function store() {
        request()->validate([
            // TO DO
        ]);
    }
}
