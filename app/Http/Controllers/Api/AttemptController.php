<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    // GET /api/attempts/stats -> {attempted, correct, accuracy}
    public function stats(Request $request)
    {
        $q = Attempt::where('user_id', $request->user()->id);
        $attempted = (clone $q)->count();
        $correct   = (clone $q)->where('is_correct', true)->count();

        return [
            'attempted' => $attempted,
            'correct'   => $correct,
            'accuracy'  => $attempted ? (int) round($correct * 100 / $attempted) : 0,
        ];
    }

    // GET /api/attempts  (latest 100)
    public function index(Request $request)
    {
        return Attempt::where('user_id', $request->user()->id)
            ->latest()->limit(100)->get();
    }

    // POST /api/attempts {subject_id, question_id, selected}
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id'  => 'required|integer|exists:subjects,id',
            'question_id' => 'required|integer|exists:questions,id',
            'selected'    => 'nullable|integer|min:0|max:9',
        ]);

        // correctness is decided on the server, so users cannot fake their score
        $question = Question::findOrFail($data['question_id']);

        Attempt::create([
            'user_id'     => $request->user()->id,
            'subject_id'  => $data['subject_id'],
            'question_id' => $question->id,
            'selected'    => $data['selected'] ?? null,
            'is_correct'  => isset($data['selected']) && (int) $data['selected'] === (int) $question->answer,
        ]);

        return response()->json(['message' => 'Saved'], 201);
    }
}
