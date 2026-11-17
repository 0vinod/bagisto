<?php

namespace App\Http\Controllers\Supa;

use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with('subject')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($w) use ($request) {
                $w->where('question', 'like', '%' . $request->search . '%')
                  ->orWhere('topic', 'like', '%' . $request->search . '%');
            }))
            ->when($request->filled('subject_id'), fn ($q) => $q->where('subject_id', $request->subject_id))
            ->latest('id')
            ->paginate(200);

        return view('backend.supa.questions.index', [
            'questions' => $questions,
            'subjects'  => Subject::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('backend.supa.questions.form', [
            'question' => new Question(['options' => ['', '', '', ''], 'answer' => 0]),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Question::create($this->validated($request));

        return redirect()->route('questions.index')->with('success', 'Question added successfully.');
    }

    public function edit(Question $question)
    {
        return view('backend.supa.questions.form', [
            'question' => $question,
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $question->update($this->validated($request));

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('success', 'Question deleted.');
    }

    /** Delete several selected rows at once. */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer'])['ids'];
        $count = Question::whereIn('id', $ids)->delete();

        return back()->with('success', "$count question(s) deleted.");
    }

    public function importForm()
    {
        return view('backend.supa.questions.import', ['subjects' => Subject::orderBy('name')->get()]);
    }

    public function import(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'file'       => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new QuestionsImport((int) $data['subject_id']);
        Excel::import($import, $request->file('file'));

        $msg = "{$import->imported} imported, {$import->skipped} duplicate(s) skipped, " . count($import->errors) . ' row(s) failed.';

        return redirect()->route('questions.index')
            ->with('success', $msg)
            ->with('import_errors', $import->errors);
    }

    /** Downloadable CSV template. */
    public function template()
    {
        $rows = [
            ['Theorist / Topic', 'Question', 'Option A', 'Option B', 'Option C', 'Option D', 'Correct Answer', 'Explanation'],
            ['Jean Piaget', 'Object permanence develops in which Piaget stage?', 'Sensorimotor', 'Preoperational', 'Concrete operational', 'Formal operational', 'A', 'Babies learn objects exist even when hidden.'],
        ];

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Hindi text opens correctly in Excel
            foreach ($rows as $r) fputcsv($out, $r);
            fclose($out);
        }, 'questions_template.csv', ['Content-Type' => 'text/csv']);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'topic'       => 'nullable|string|max:255',
            'question'    => 'required|string',
            'options'     => 'required|array|size:4',
            'options.*'   => 'required|string|max:500',
            'answer'      => 'required|integer|between:0,3',
            'explanation' => 'nullable|string',
        ]);

        $data['options'] = array_values($data['options']);

        return $data;
    }
}
