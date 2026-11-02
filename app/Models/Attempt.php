<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $table = 'attempts';
    public $timestamps = false;

    protected $fillable = ['user_id', 'subject_id', 'question_id', 'selected', 'is_correct', 'created_at'];
}
