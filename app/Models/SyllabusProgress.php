<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusProgress extends Model
{
    protected $guarded = [];

    protected $table = 'syllabus_progress';

    public function item(){
        return $this->belongsTo(SyllabusItem::class,'item_id');
    }
}
