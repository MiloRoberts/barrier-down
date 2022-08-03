<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsoleManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function game_console() {
        return $this->hasMany(GameConsole::class);
    }
}
