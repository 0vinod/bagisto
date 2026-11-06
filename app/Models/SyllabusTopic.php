<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusTopic extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(SyllabusItem::class, 'topic_id')->orderBy('sort_order');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id')->orderByDesc('id');
    }
}
