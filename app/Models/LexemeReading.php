<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LexemeReading extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function lexemes() {
        return $this->hasMany(Lexeme::class);
    }
}
