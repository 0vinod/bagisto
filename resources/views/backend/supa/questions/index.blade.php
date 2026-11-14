@extends('backend.layouts.master')

@section('title', 'Questions')
@section('main-content')

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h4 class="mb-2 mb-sm-0 font-weight-bold text-primary">
        Questions <span class="badge badge-secondary">{{ $questions->total() }}</span>
    </h4>
    <div class="d-flex w-100 w-sm-auto" style="gap:.5rem">
        <a href="{{ route('questions.import.form') }}" class="btn btn-outline-success flex-fill">Import Excel/CSV</a>
        <a href="{{ route('questions.create') }}" class="btn btn-primary flex-fill">+ Add Question</a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="card card-body shadow-sm mb-3 py-3">
    <div class="form-row">
        <div class="form-group col-12 col-md-5 mb-2 mb-md-0">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Search question or topic...">
        </div>
        <div class="form-group col-12 col-md-4 mb-2 mb-md-0">
            <select name="subject_id" class="form-control">
                <option value="">All subjects</option>
                @foreach ($subjects as $s)
                    <option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex" style="gap:.5rem">
            <button class="btn btn-secondary flex-fill">Filter</button>
            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
        </div>
    </div>
</form>

{{-- ===================== DESKTOP / TABLET: TABLE ===================== --}}
<form method="POST" action="{{ route('questions.bulk-destroy') }}" id="bulkForm"
      onsubmit="return confirm('Delete all selected questions?')">
    @csrf @method('DELETE')

    <div class="card shadow-sm d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                <tr>
                    <th style="width:30px"><input type="checkbox" id="checkAll"></th>
                    <th>#</th>
                    <th>Subject / Topic</th>
                    <th style="min-width:280px">Question &amp; Options</th>
                    <th>Answer</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($questions as $q)
                    <tr>
                        <td class="align-middle"><input type="checkbox" name="ids[]" value="{{ $q->id }}" class="rowCheck"></td>
                        <td class="align-middle">{{ $q->id }}</td>
                        <td class="align-middle">
                            <div>{{ $q->subject->name ?? '—' }}</div>
                            <small class="text-muted">{{ $q->topic }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $q->question }}</div>
                            <ol type="A" class="small mb-0 pl-3">
                                @foreach ($q->options as $i => $opt)
                                    <li class="{{ $i === $q->answer ? 'text-success font-weight-bold' : '' }}">{{ $opt }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td class="align-middle"><span class="badge badge-success">{{ chr(65 + $q->answer) }}</span></td>
                        <td class="align-middle text-right text-nowrap">
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

    <button class="btn btn-danger btn-sm mt-3 d-none d-md-inline-block">Delete selected</button>
</form>

{{-- ===================== MOBILE: CARDS ===================== --}}
<div class="d-md-none">
    @forelse ($questions as $q)
        <div class="card shadow-sm mb-3">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge badge-secondary">#{{ $q->id }}</span>
                        <span class="small font-weight-bold">{{ $q->subject->name ?? '—' }}</span>
                        @if ($q->topic)<div class="small text-muted">{{ $q->topic }}</div>@endif
                    </div>
                    <span class="badge badge-success">Ans: {{ chr(65 + $q->answer) }}</span>
                </div>

                <p class="font-weight-bold mb-2">{{ $q->question }}</p>

                <ol type="A" class="small pl-3 mb-3">
                    @foreach ($q->options as $i => $opt)
                        <li class="{{ $i === $q->answer ? 'text-success font-weight-bold' : '' }}">{{ $opt }}</li>
                    @endforeach
                </ol>

                <div class="d-flex" style="gap:.5rem">
                    <a href="{{ route('questions.edit', $q) }}" class="btn btn-sm btn-outline-primary flex-fill">Edit</a>
                    <button type="submit" form="del-{{ $q->id }}" class="btn btn-sm btn-outline-danger flex-fill"
                            onclick="return confirm('Delete this question?')">Delete</button>
                </div>
            </div>
        </div>
    @empty
        <div class="card card-body text-center text-muted">No questions found.</div>
    @endforelse
</div>

{{-- Single-delete forms (outside the bulk form: HTML forbids nested forms) --}}
@foreach ($questions as $q)
    <form id="del-{{ $q->id }}" method="POST" action="{{ route('questions.destroy', $q) }}" class="d-none">
        @csrf @method('DELETE')
    </form>
@endforeach

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-center justify-content-md-start overflow-auto">
    {{ $questions->links() }}
</div>

<script>
    document.getElementById('checkAll')?.addEventListener('change', e =>
        document.querySelectorAll('.rowCheck').forEach(c => c.checked = e.target.checked));
</script>
@endsection