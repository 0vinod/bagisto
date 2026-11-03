<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SyllabusProgress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        // Only return progress for the logged-in user
        return response()->json(
            SyllabusProgress::where('user_id', $request->user()->id)->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:syllabus_items,id'
        ]);

        // Prevent duplicates
        $progress = SyllabusProgress::firstOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $request->item_id,
        ]);

        return response()->json($progress, 201);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'item_id' => 'required'
        ]);

        SyllabusProgress::where('user_id', $request->user()->id)
            ->where('item_id', $request->item_id)
            ->delete();

        return response()->json(null, 204);
    }
}