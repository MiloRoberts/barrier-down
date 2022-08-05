<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenshotSize extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function screenshot() {
        return $this->hasMany(Screenshot::class);
    }
}
