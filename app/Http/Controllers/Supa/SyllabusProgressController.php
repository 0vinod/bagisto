<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\SyllabusProgress;
use App\Models\SyllabusItem;
use Illuminate\Http\Request;

class SyllabusProgressController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $progress = SyllabusProgress::where('user_id', $userId)
            ->with('item.topic.subject')
            ->latest('created_at')
            ->paginate(20);

        $items = SyllabusItem::with('topic.subject')->orderBy('topic_id')->orderBy('sort_order')->get();
        $doneIds = SyllabusProgress::where('user_id', $userId)->pluck('item_id')->toArray();

        return view('backend.supa.progress.index', compact('progress', 'items', 'doneIds'));
    }

    public function toggle(Request $request, $itemId)
    {
        $userId = auth()->id();
        $item   = SyllabusItem::findOrFail($itemId);

        $existing = SyllabusProgress::where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'unchecked';
        } else {
            SyllabusProgress::create([
                'user_id'    => $userId,
                'item_id'    => $itemId,
                'created_at' => now(),
            ]);
            $status = 'checked';
        }

        return response()->json(['status' => $status]);
    }
}
