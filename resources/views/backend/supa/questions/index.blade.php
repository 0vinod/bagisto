@extends('backend.layouts.master')
@section('main-content')
@section('title', 'Questions')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h4 class="mb-0">Questions <span class="badge bg-secondary">{{ $questions->total() }}</span></h4>
    <div>
        <a href="{{ route('questions.import.form') }}" class="btn btn-outline-success">Import Excel/CSV</a>
        <a href="{{ route('questions.create') }}" class="btn btn-primary">+ Add Question</a>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-5"><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search question or topic..."></div>
    <div class="col-md-4">
        <select name="subject_id" class="form-select">
            <option value="">All subjects</option>
            @foreach ($subjects as $s)
                <option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-grid d-md-flex gap-2">
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<form method="POST" action="{{ route('questions.bulk-destroy') }}" id="bulkForm" onsubmit="return confirm('Delete all selected questions?')">
    @csrf @method('DELETE')
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th style="width:30px"><input type="checkbox" id="checkAll"></th>
                    <th>#</th><th>Subject / Topic</th><th style="min-width:280px">Question &amp; Options</th>
                    <th>Answer</th><th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($questions as $q)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $q->id }}" class="rowCheck"></td>
                        <td>{{ $q->id }}</td>
                        <td>
                            <div>{{ $q->subject->name ?? '—' }}</div>
                            <small class="text-muted">{{ $q->topic }}</small>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $q->question }}</div>
                            <ol type="A" class="small mb-0 ps-3">
                                @foreach ($q->options as $i => $opt)
                                    <li class="{{ $i === $q->answer ? 'text-success fw-bold' : '' }}">{{ $opt }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td><span class="badge bg-success">{{ chr(65 + $q->answer) }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('questions.edit', $q) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <button type="submit" form="del-{{ $q->id }}" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this question?')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No questions found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <button class="btn btn-danger btn-sm mt-3">Delete selected</button>
</form>

{{-- Single-delete forms live outside the bulk form (HTML forbids nesting) --}}
@foreach ($questions as $q)
    <form id="del-{{ $q->id }}" method="POST" action="{{ route('questions.destroy', $q) }}" class="d-none">@csrf @method('DELETE')</form>
@endforeach

<div class="mt-3">{{ $questions->links() }}</div>

<script>
    document.getElementById('checkAll')?.addEventListener('change', e =>
        document.querySelectorAll('.rowCheck').forEach(c => c.checked = e.target.checked));
</script>
@endsection
