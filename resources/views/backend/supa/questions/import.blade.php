@extends('backend.layouts.master')

@section('title', 'Import Questions')
@section('main-content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-primary">Import Questions (Excel / CSV)</h5>
        <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-secondary mt-2 mt-sm-0">&larr; Back</a>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('questions.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-12 col-md-5">
                    <label for="subject_id">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" id="subject_id"
                            class="form-control @error('subject_id') is-invalid @enderror" required>
                        <option value="">-- Select --</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group col-12 col-md-7">
                    <label for="file">File (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                    <div class="custom-file">
                        <input type="file" name="file" id="file"
                               class="custom-file-input @error('file') is-invalid @enderror"
                               accept=".xlsx,.xls,.csv" required>
                        <label class="custom-file-label text-truncate" for="file">Choose file...</label>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Full-width stacked buttons on phones, inline on larger screens --}}
            <div class="d-flex flex-column flex-sm-row">
                <button type="submit" class="btn btn-success px-4 mb-2 mb-sm-0 mr-sm-2">Import</button>
                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary px-4">Back</a>
            </div>
        </form>

        <hr>

        <h6 class="font-weight-bold">File format</h6>
        <p class="mb-2">Only the <b>first sheet</b> is read. Row 1 must be the heading row:</p>

        {{-- Column names as wrapping badges so they never overflow on small screens --}}
        <div class="mb-3">
            @foreach (['Theorist / Topic', 'Question', 'Option A', 'Option B', 'Option C', 'Option D', 'Correct Answer', 'Explanation'] as $col)
                <span class="badge badge-light border mr-1 mb-1 p-2">{{ $col }}</span>
            @endforeach
        </div>

        <ul class="small pl-3">
            <li>Correct Answer can be <b>A / B / C / D</b> (or 1–4, or text like "B) Lev Vygotsky").</li>
            <li>Your Super TET Excel files work as they are (extra columns like "Q. No." are ignored).</li>
            <li>Questions already present in the same subject are skipped (no duplicates).</li>
        </ul>

        <a href="{{ route('questions.template') }}" class="btn btn-sm btn-outline-primary">
            Download CSV template
        </a>
    </div>
</div>

<script>
    // Bootstrap 4 does not update the custom file label by itself
    document.getElementById('file')?.addEventListener('change', function () {
        this.nextElementSibling.textContent = this.files[0]?.name || 'Choose file...';
    });
</script>
@endsection