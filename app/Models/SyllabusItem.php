<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusItem extends Model
{

    protected $table = 'syllabus_items';
    public $timestamps = false;

    protected $fillable = ['topic_id', 'heading', 'sort_order'];

    public function topic()
    {
        return $this->belongsTo(SyllabusTopic::class, 'topic_id');
    }
}
