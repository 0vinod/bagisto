<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TetUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tet_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(Profile::class, 'id');
    }

    public function syllabusProgress()
    {
        return $this->hasMany(SyllabusProgress::class, 'user_id');
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class, 'user_id');
    }
}