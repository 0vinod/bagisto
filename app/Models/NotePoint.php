<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotePoint extends Model
{
    protected $guarded = [];

    protected $casts = ['points' => 'array'];
}
