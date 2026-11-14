@extends('backend.layouts.master')
@section('title', 'Import Questions')
@section('main-content')
<div class="card shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">Import Questions (Excel / CSV)</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('questions.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">-- Select --</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label">File (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
            </div>
            <button class="btn btn-success mt-3">Import</button>
            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary mt-3">Back</a>
        </form>

        <hr>
        <h6>File format</h6>
        <p class="mb-1">Only the <b>first sheet</b> is read. Row 1 must be the heading row:</p>
        <code>Theorist / Topic | Question | Option A | Option B | Option C | Option D | Correct Answer | Explanation</code>
        <ul class="mt-2 small">
            <li>Correct Answer can be <b>A / B / C / D</b> (or 1–4, or text like "B) Lev Vygotsky").</li>
            <li>Your Super TET Excel files work as they are (extra columns like "Q. No." are ignored).</li>
            <li>Questions already present in the same subject are skipped (no duplicates).</li>
        </ul>
        <a href="{{ route('questions.template') }}" class="btn btn-sm btn-outline-primary">Download CSV template</a>
    </div>
</div>
@endsection
