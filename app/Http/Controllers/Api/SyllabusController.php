<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SyllabusTopic;
use App\Models\SyllabusItem;
use Illuminate\Http\Request;

class SyllabusController extends Controller
{
    public function topics(Request $request)
    {
        $query = SyllabusTopic::with(['items' => function($q) {
            $q->orderBy('sort_order');
        }])->orderBy('sort_order');

        if ($request->has('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('id')) {
            return response()->json($query->where('id', $request->id)->get());
        }

        return response()->json($query->get());
    }

    public function items(Request $request)
    {
        $query = SyllabusItem::query();

        if ($request->has('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        return response()->json($query->orderBy('sort_order')->get());
    }
}