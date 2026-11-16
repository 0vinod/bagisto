<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function attempt()
    {
        return $this->hasOne(Attempt::class, 'question_id')
            ->where('user_id', auth()->id());
    }

    public function getSelectedAttribute()
    {
        return $this->attempt?->selected;
    }
}
