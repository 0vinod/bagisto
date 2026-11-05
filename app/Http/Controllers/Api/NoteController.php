<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    // GET /api/notes?subject_id=1  -> notes with points: [{heading, points:[...]}]
    public function index(Request $request)
    {
        return Note::with('points')
            ->when($request->subject_id, fn ($q, $id) => $q->where('subject_id', $id))
            ->orderBy('sort_order')
            ->get();
    }
}
