<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [];

    public function points()
    {
        return $this->hasMany(NotePoint::class)->orderBy('sort_order');
    }
}
