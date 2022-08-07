<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanji extends Model
{
    use HasFactory;

    protected $table = 'kanji';

    protected $fillable = [];

    public function lexemes() {
        return $this->belongsToMany(LexemeClass::class);
    }
}
