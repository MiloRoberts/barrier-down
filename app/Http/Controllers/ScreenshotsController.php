<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScreenshotsController extends Controller
{
    public function create() {
        return view('screenshots.create');
    }
}
