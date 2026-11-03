<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{

    protected $table = 'attempts';
    public $timestamps = false;

    protected $fillable = ['user_id', 'subject_id', 'question_id', 'selected', 'is_correct', 'created_at'];

    
    public function user()
    {
        return $this->belongsTo(TetUser::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
