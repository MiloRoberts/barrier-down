<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanji extends Model
{
    use HasFactory;

    protected $table = 'kanji';

    protected $fillable = [];
    
    public function kanji_character() {
        return $this->belongsTo(KanjiCharacter::class);
    }

    public function kanji_meaning() {
        return $this->belongsTo(KanjiMeaning::class);
    }

    public function kanji_reading() {
        return $this->belongsTo(KanjiReading::class);
    }

    public function lexemes() {
        return $this->belongsToMany(LexemeClass::class);
    }
    
    // // I guess this is unnecessary after all.
    // public function lexemes() {
        //     return $this->belongsToMany(LexemeClass::class, 'kanji_lexemes', 'kanji_id', 'lexeme_id');
        // }
}
