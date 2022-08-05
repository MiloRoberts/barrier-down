<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function game() {
        return $this->belongsTo(Game::class);
    }

    public function screenshot_number() {
        return $this->belongsTo(ScreenshotNumber::class);
    }

    public function screenshot_size() {
        return $this->belongsTo(ScreenshotSize::class);
    }
}
