<?php

namespace App\Http\Controllers;

use App\Models\SyllabusTopic;
use App\Models\SyllabusItem;
use Illuminate\Http\Request;

class SyllabusItemController extends Controller
{
    public function index()
    {
        $items = SyllabusItem::with('topic.subject')
            ->orderBy('topic_id')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('items.index', compact('items'));
    }

    public function create(Request $request)
    {
        $topics = SyllabusTopic::with('subject')->orderBy('name')->get();
        $selectedTopic = $request->get('topic_id');
        return view('items.create', compact('topics', 'selectedTopic'));
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
        return view('items.show', compact('item'));
    }

    public function edit(SyllabusItem $item)
    {
        $topics = SyllabusTopic::with('subject')->orderBy('name')->get();
        return view('items.edit', compact('item', 'topics'));
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
