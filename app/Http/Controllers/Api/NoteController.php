<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

 
class NoteController extends Controller
{
    // make relative paths absolute so the app (on another domain) can load them
    private function img(?string $v): ?string
    {
        if (!$v) return null;
        return preg_match('#^https?://#i', $v) ? $v : url($v);
    }

    public function index(Request $request)
    {
        $notes = Note::with('points')
            ->when($request->subject_id, fn ($q, $id) => $q->where('subject_id', $id))
            ->orderBy('sort_order')
            ->get();

        return response()->json($notes->map(fn ($n) => [
            'id'          => $n->id,
            'subject_id'  => $n->subject_id,
            'title'       => $n->title,
            'image_url'   => $this->img($n->image_url),
            'icon_url'    => $this->img($n->icon_url),
            'short_notes' => $n->short_notes ?? $n->Short_notes ?? null,
            'sort_order'  => $n->sort_order,
            'points'      => $n->points->map(fn ($p) => [
                'id'           => $p->id,
                'heading'      => $p->heading,
                'sub_headings' => $p->sub_headings,
                'sub_heading'  => $p->sub_headings,   // alias, matches the app's current code
                'image_url'    => $this->img($p->image_url),
                'points'       => is_array($p->points) ? $p->points : [],
                'sort_order'   => $p->sort_order,
            ])->values(),
        ])->values());
    }
}
