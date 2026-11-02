<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusTopic extends Model
{
    protected $connection = 'pgsql'; 
    protected $table = 'syllabus_topics';
    public $timestamps = false;

    protected $fillable = ['subject_id', 'name', 'detail', 'sort_order'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function items()
    {
        return $this->hasMany(SyllabusItem::class, 'topic_id')->orderBy('sort_order');
    }
}
