<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class QuestionController extends Controller
{
    // GET /api/questions?subject_id=1
    public function index(Request $request)
    {
        return Question::when($request->subject_id, fn ($q, $id) => $q->where('subject_id', $id))
            ->inRandomOrder()
            ->get();
    }
}
