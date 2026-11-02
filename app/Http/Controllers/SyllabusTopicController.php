<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SyllabusTopic;
use Illuminate\Http\Request;

class SyllabusTopicController extends Controller
{
    public function index()
    {
        $topics = SyllabusTopic::with('subject', 'items')
            ->orderBy('subject_id')
            ->orderBy('sort_order')
            ->paginate(15);

        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('topics.create', compact('subjects'));
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
        return view('topics.show', compact('topic'));
    }

    public function edit(SyllabusTopic $topic)
    {
        $subjects = Subject::orderBy('name')->get();
        return view('topics.edit', compact('topic', 'subjects'));
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
