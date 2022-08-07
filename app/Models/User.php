<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// add prunable as well in addition to soft deletes?

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Is this pivot correct?
    public function games() {
        return $this->belongsToMany(Game::class)
            ->withPivot('contributor', 'learning');
    }

    // Game::class, 'games_users', 'game_id', 'user_id'
    
    public function lexemes() {
        return $this->belongsToMany(Lexeme::class);
    }

    // see laracasts episode 46 at 3:00 for more on eloquent mutators
    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }
}
