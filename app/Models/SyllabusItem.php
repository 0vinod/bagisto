<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusItem extends Model
{
    protected $guarded = [];

    public function topic(){
        return $this->belongsTo(SyllabusTopic::class,'topic_id');
    }
}
