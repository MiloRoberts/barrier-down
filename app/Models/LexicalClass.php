<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LexicalClass extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function lexemes() {
        return $this->belongsToMany(LexemeClass::class);
    }
}
