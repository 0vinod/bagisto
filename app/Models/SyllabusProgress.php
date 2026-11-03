<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusProgress extends Model
{

    protected $table = 'syllabus_progress';
    public $timestamps = false;

    protected $fillable = ['user_id', 'item_id', 'created_at'];
}
