<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Support\Facades;
use Illuminate\Support\Facades\File;

class Game {
    public static function all() {
        $files = File::files(resource_path("games/"));

        return array_map(function ($file) {
            return $file->getContents();
        }, $files);
    }

    public static function find($slug) {
        $path = resource_path("games/{$slug}.html");
 
        if (! file_exists($path)) {
            throw new ModelNotFoundException();
        }

        return cache()->remember('games.{$slug}', now()->addMinutes(20), function () use ($path) {
            return file_get_contents($path);
        });

        return $game;
    }
}