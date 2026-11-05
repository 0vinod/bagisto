<?php

namespace App\Http\Controllers\Api;

use App\Models\SyllabusItem;
use App\Models\SyllabusTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyllabusController extends Controller
{
    // GET /api/syllabus_topics?subject_id=1  -> topics with items[]
    public function topics(Request $request)
    {
        return SyllabusTopic::with('items')
            ->when($request->subject_id, fn ($q, $id) => $q->where('subject_id', $id))
            ->orderBy('sort_order')
            ->get();
    }

    // GET /api/syllabus_items?topic_id=1
    public function items(Request $request)
    {
        return SyllabusItem::when($request->topic_id, fn ($q, $id) => $q->where('topic_id', $id))
            ->orderBy('sort_order')
            ->get();
    }
}
