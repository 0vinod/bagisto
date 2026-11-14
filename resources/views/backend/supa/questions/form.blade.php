@extends('backend.layouts.master')

@php $isEdit = $question->exists; @endphp
@section('title', $isEdit ? 'Edit Question' : 'Add Question')
@section('main-content')
<div class="card shadow-sm">
    <div class="card-header bg-white"><h5 class="mb-0">{{ $isEdit ? 'Edit Question #' . $question->id : 'Add New Question' }}</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ $isEdit ? route('questions.update', $question) : route('questions.store') }}">
            @csrf
            @if ($isEdit) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">-- Select --</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id', $question->subject_id) == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Topic</label>
                    <input type="text" name="topic" class="form-control" value="{{ old('topic', $question->topic) }}" placeholder="e.g. Jean Piaget">
                </div>
                <div class="col-12">
                    <label class="form-label">Question <span class="text-danger">*</span></label>
                    <textarea name="question" rows="2" class="form-control" required>{{ old('question', $question->question) }}</textarea>
                </div>

                <div class="col-12"><label class="form-label">Options <span class="text-danger">*</span> (select the correct one)</label></div>
                @php $answer = (int) old('answer', $question->answer ?? 0); @endphp
                @foreach (range(0, 3) as $i)
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="answer" value="{{ $i }}" @checked($answer === $i) required>
                                <span class="ms-2 fw-bold">{{ chr(65 + $i) }}</span>
                            </div>
                            <input type="text" name="options[{{ $i }}]" class="form-control" required
                                   value="{{ old("options.$i", $question->options[$i] ?? '') }}">
                        </div>
                    </div>
                @endforeach

                <div class="col-12">
                    <label class="form-label">Explanation</label>
                    <textarea name="explanation" rows="2" class="form-control">{{ old('explanation', $question->explanation) }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary">{{ $isEdit ? 'Update' : 'Save' }}</button>
                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
