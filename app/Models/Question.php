<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    protected $casts = ['options' => 'array', 'answer' => 'integer'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getCorrectOptionAttribute(): ?string
    {
        return $this->options[$this->answer] ?? null;
    }
}
