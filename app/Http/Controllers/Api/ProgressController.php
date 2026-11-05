<?php

namespace App\Http\Controllers\Api;

use App\Models\SyllabusProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    // GET /api/syllabus_progress -> [{item_id: 3}, ...] (logged-in user only)
    public function index(Request $request)
    {
        return SyllabusProgress::where('user_id', $request->user()->id)->get(['item_id']);
    }

    // POST /api/syllabus_progress  {item_id}
    public function store(Request $request)
    {
        $data = $request->validate(['item_id' => 'required|integer|exists:syllabus_items,id']);

        SyllabusProgress::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $data['item_id'],
        ]);

        return response()->json(['message' => 'Saved'], 201);
    }

    // DELETE /api/syllabus_progress?item_id=3
    public function destroy(Request $request)
    {
        $data = $request->validate(['item_id' => 'required|integer']);

        SyllabusProgress::where('user_id', $request->user()->id)
            ->where('item_id', $data['item_id'])
            ->delete();

        return response()->noContent();
    }
}
