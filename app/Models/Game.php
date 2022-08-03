<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function game_console() {
        return $this->belongsTo(GameConsole::class);
    }

    public function game_title() {
        return $this->belongsTo(GameTitle::class);
    }
}
