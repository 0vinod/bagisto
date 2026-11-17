<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'emoji' => 'nullable|string|max:10',
            'image_url'   => 'nullable|image|max:10096',
            'color' => 'nullable|string|max:20',
            'short_note' => 'nullable|string',
            'weightage'  => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ];
    }

    public function index()
    {
        $subjects = Subject::orderBy('sort_order')->get();
        return view('backend.supa.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('backend.supa.subjects.create');
    }

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
    public function store(Request $request)
    {
        $data = $this->saveFiles($request, $request->validate($this->rules()));
        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        return view('backend.supa.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $this->saveFiles($request, $request->validate($this->rules()));
        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
