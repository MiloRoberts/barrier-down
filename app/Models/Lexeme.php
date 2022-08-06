<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lexeme extends Model
{
    use HasFactory;

    public function games() {
        return $this->belongsToMany(Game::class);
    }

    // Is this pivot correct?
    public function users() {
        return $this->belongsToMany(User::class)
            ->withPivot('learning');
    }
}