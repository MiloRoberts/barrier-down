<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameConsole extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function games() {
        return $this->hasMany(Game::class);
    }

    public function console_manufacturer() {
        return $this->belongsTo(ConsoleManufacturer::class);
    }

    public function console_name() {
        return $this->belongsTo(ConsoleName::class);
    }
}
