<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function index()
    {
        $attempts = Attempt::where('user_id', auth()->id())
            ->with('subject')
            ->latest('created_at')
            ->paginate(20);

        return view('backend.supa.attempts.index', compact('attempts'));
    }

    public function show(Attempt $attempt)
    {
        abort_unless($attempt->user_id === auth()->id(), 403);
        return view('backend.supa.attempts.show', compact('attempt'));
    }

    public function destroy(Attempt $attempt)
    {
        abort_unless($attempt->user_id === auth()->id(), 403);
        $attempt->delete();
        return redirect()->route('attempts.index')->with('success', 'Attempt deleted.');
    }
}
