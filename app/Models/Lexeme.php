<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lexeme extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function games() {
        return $this->belongsToMany(Game::class);
    }
    
    public function kanji() {
        return $this->belongsToMany(LexemeClass::class);
    }

    // // I guess this is unnecessary after all.
    // public function kanji() {
    //     return $this->belongsToMany(LexemeClass::class, 'kanji_lexemes', 'lexeme_id', 'kanji_id');
    // }

    public function lexeme_item() {
        return $this->belongsTo(LexemeItem::class);
    }

    public function lexeme_meaning() {
        return $this->belongsTo(LexemeMeaning::class);
    }
    
    public function lexeme_reading() {
        return $this->belongsTo(LexemeReading::class);
    }

    public function lexical_classes() {
        return $this->belongsToMany(LexicalClass::class);
    }

    // Is this pivot correct?
    public function users() {
        return $this->belongsToMany(User::class)
            ->withPivot('learning');
    }
}
