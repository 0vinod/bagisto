<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function syllabusTopics()
    {
        return $this->hasMany(SyllabusTopic::class);
    }
}
