<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\SyllabusTopic;
use App\Models\SyllabusItem;
use Illuminate\Http\Request;

class SyllabusItemController extends Controller
{
    public function index()
    {
        $items = SyllabusItem::with('topic.subject')
            ->join('syllabus_topics', 'syllabus_items.topic_id', '=', 'syllabus_topics.id')
            ->orderBy('syllabus_topics.subject_id')
            ->orderBy('syllabus_topics.name')
            ->orderBy('syllabus_items.sort_order')
            ->select('syllabus_items.*')
            ->paginate(20);
            
        return view('backend.supa.items.index', compact('items'));
    }

    public function create(Request $request)
    {
        $topics = SyllabusTopic::with('subject')->orderBy('name')->get();
        $selectedTopic = $request->get('topic_id');
        return view('backend.supa.items.create', compact('topics', 'selectedTopic'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic_id'   => 'required|exists:syllabus_topics,id',
            'heading'    => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        SyllabusItem::create($data);
        return redirect()->route('items.index')->with('success', 'Item created.');
    }

    public function show(SyllabusItem $item)
    {
        $item->load('topic.subject');
        return view('backend.supa.items.show', compact('item'));
    }

    public function edit(SyllabusItem $item)
    {
        $topics = SyllabusTopic::with('subject')->orderBy('name')->get();
        return view('backend.supa.items.edit', compact('item', 'topics'));
    }

    public function update(Request $request, SyllabusItem $item)
    {
        $data = $request->validate([
            'topic_id'   => 'required|exists:syllabus_topics,id',
            'heading'    => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $item->update($data);
        return redirect()->route('items.index')->with('success', 'Item updated.');
    }

    public function destroy(SyllabusItem $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted.');
    }
}
