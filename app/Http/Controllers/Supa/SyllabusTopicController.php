<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SyllabusTopic;
use Illuminate\Http\Request;

class SyllabusTopicController extends Controller
{
    public function index()
    {
       $topics = SyllabusTopic::with('subject')
        ->withCount('items')
        ->orderBy('subject_id')
        ->orderBy('name')
        ->paginate(20);

        return view('backend.supa.topics.index', compact('topics'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('backend.supa.topics.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name'       => 'required|string|max:255',
            'detail'     => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        SyllabusTopic::create($data);
        return redirect()->route('topics.index')->with('success', 'Topic created.');
    }

    public function show(SyllabusTopic $topic)
    {
        $topic->load('items', 'subject');
        return view('backend.supa.topics.show', compact('topic'));
    }

    public function edit(SyllabusTopic $topic)
    {
        $subjects = Subject::orderBy('name')->get();
        return view('backend.supa.topics.edit', compact('topic', 'subjects'));
    }

    public function update(Request $request, SyllabusTopic $topic)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name'       => 'required|string|max:255',
            'detail'     => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $topic->update($data);
        return redirect()->route('topics.index')->with('success', 'Topic updated.');
    }

    public function destroy(SyllabusTopic $topic)
    {
        $topic->delete();
        return redirect()->route('topics.index')->with('success', 'Topic deleted.');
    }
}
