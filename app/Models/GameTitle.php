<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTitle extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function game() {
        return $this->hasMany(Game::class);
    }
}
