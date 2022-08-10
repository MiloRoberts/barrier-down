<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTitle extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function games() {
        return $this->hasMany(Game::class);
    }

    // I should perhaps add a function to return the english_title as the default when searching for the title.
}
