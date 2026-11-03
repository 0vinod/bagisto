<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'question_id' => 'required|exists:questions,id',
            'selected' => 'required|integer',
            'is_correct' => 'required|boolean',
        ]);

        $attempt = Attempt::create([
            'user_id' => $request->user()->id,
            'subject_id' => $request->subject_id,
            'question_id' => $request->question_id,
            'selected' => $request->selected,
            'is_correct' => $request->is_correct,
        ]);

        return response()->json($attempt, 201);
    }
}