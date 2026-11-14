<?php
// app/Http/Controllers/Supa/NoteController.php
namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Subject;
use Illuminate\Http\Request;

class NoteController extends Controller
{
       private function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'image_url'   => 'nullable|image|max:4096',   // file upload
            'icon_url'    => 'nullable|image|max:2048',   // file upload
            'short_notes' => 'nullable|string',
            'weightage'   => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ];
    }

    // saves uploaded files and stores their full URL; keeps old value when no file is sent
    private function saveFiles(Request $request, array $data): array
    {
        foreach (['image_url', 'icon_url'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $name = uniqid('n_') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/notes'), $name);
                $data[$field] = url('public/uploads/notes/' . $name);
            } else {
                unset($data[$field]);
            }
        }
        return $data;
    }

    public function index(Subject $subject)
    {
        $notes = $subject->notes()->withCount('points')->get();
        return view('backend.supa.notes.index', compact('subject', 'notes'));
    }

    public function create(Subject $subject)
    {
        return view('backend.supa.notes.create', compact('subject'));
    }

    public function store(Request $request, Subject $subject)
    {
        $data = $this->saveFiles($request, $request->validate($this->rules()));
        $data['subject_id'] = $subject->id;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $note = Note::create($data);
        return redirect()->route('subjects.notes.index', $subject)->with('success', 'Note created. Now add its sections.');
    }

    public function show(Note $note)
    {
        $note->load('subject', 'points');
        return view('backend.supa.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $subject = $note->subject;
        return view('backend.supa.notes.edit', compact('note', 'subject'));
    }

    public function update(Request $request, Note $note)
    {
        $data = $this->saveFiles($request, $request->validate($this->rules()));
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $note->update($data);
        return redirect()->route('subjects.notes.index', $note->subject_id)->with('success', 'Note updated.');
    }

    public function destroy(Note $note)
    {
        $subjectId = $note->subject_id;
        $note->points()->delete();
        $note->delete();
        return redirect()->route('subjects.notes.index', $subjectId)->with('success', 'Note deleted.');
    }
}