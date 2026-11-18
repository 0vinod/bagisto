<?php
// app/Http/Controllers/Supa/NotePointController.php
namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\NotePoint;
use Illuminate\Http\Request;

class NotePointController extends Controller
{
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'heading'                 => 'nullable|string|max:255',
            'sort_order'              => 'nullable|integer',
            'points'                  => 'nullable|array',
            'points.*.sub_heading'    => 'nullable|string|max:255',
            'points.*.image'          => 'nullable|image|max:4096',   // 4 MB per image
            'points.*.existing_image' => 'nullable|string',
            'points.*.texts'          => 'nullable|array',
            'points.*.texts.*'        => 'nullable|string',
            'image_url'               => 'nullable|image|max:20096',
        ]);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $name = uniqid('np_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/note-points'), $name);
            $data['image_url'] = url('public/uploads/note-points/' . $name);
        } else {
            // no new file: keep the old image on edit, null on create
            unset($data['image_url']);
        }

        $data['points']     = $this->buildPoints($request);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function buildPoints(Request $request): array
    {
        $out    = [];
        $prefix = url('public/uploads/note-points/'); // only trust our own existing images

        foreach ($request->input('points', []) as $i => $row) {
            $sub   = trim($row['sub_heading'] ?? '');
            $texts = array_values(array_filter(
                array_map('trim', $row['texts'] ?? []),
                fn($t) => $t !== ''
            ));

            // keep old image unless a new one is uploaded
            $image = $row['existing_image'] ?? null;
            if ($image && !str_starts_with($image, $prefix)) {
                $image = null;
            }

            if ($file = $request->file("points.$i.image")) {
                $name = uniqid('np_') . '.' . $file->extension();
                $file->move(public_path('uploads/note-points'), $name);
                $image = url('public/uploads/note-points/' . $name);
            }

            // skip completely empty blocks
            if ($sub === '' && !$image && !$texts) {
                continue;
            }

            $out[] = [
                'sub_heading' => $sub,
                'image_url'   => $image,
                'texts'       => $texts,
            ];
        }

        return $out;
    }

    public function index($noteId)
    {
        $points = NotePoint::where('note_id', $noteId)->orderBy('sort_order')->get();

        return view('backend.supa.note_points.index', compact('points', 'noteId'));
    }

    public function create(Note $note)
    {
        $note->load('subject');
        $nextOrder = (int) $note->points()->max('sort_order') + 1;

        return view('backend.supa.note_points.create', compact('note', 'nextOrder'));
    }

    public function store(Request $request, Note $note)
    {
        $note->points()->create($this->validated($request));

        return redirect()->route('notes.points.index', $note)->with('success', 'Section added.');
    }

    public function edit(NotePoint $point)
    {
        $note = $point->note()->with('subject')->first();

        return view('backend.supa.note_points.edit', compact('point', 'note'));
    }

    public function update(Request $request, NotePoint $point)
    {
        $point->update($this->validated($request));

        return redirect()->route('notes.points.index', $point->note_id)->with('success', 'Section updated.');
    }

    public function destroy(NotePoint $point)
    {
        $noteId = $point->note_id;
        $point->delete();

        return redirect()->route('notes.points.index', $noteId)->with('success', 'Section deleted.');
    }
}
