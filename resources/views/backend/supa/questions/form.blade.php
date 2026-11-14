@extends('backend.layouts.master')

@php $isEdit = $question->exists; @endphp
@section('title', $isEdit ? 'Edit Question' : 'Add Question')
@section('main-content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold text-primary">
            {{ $isEdit ? 'Edit Question #' . $question->id : 'Add New Question' }}
        </h5>
        <a href="{{ route('questions.index') }}" class="btn btn-sm btn-outline-secondary mt-2 mt-sm-0">
            &larr; Back
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEdit ? route('questions.update', $question) : route('questions.store') }}">
            @csrf
            @if ($isEdit) @method('PUT') @endif

            <div class="form-row">
                {{-- Subject --}}
                <div class="form-group col-12 col-md-6">
                    <label for="subject_id">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" id="subject_id"
                            class="form-control @error('subject_id') is-invalid @enderror" required>
                        <option value="">-- Select --</option>
                        @foreach ($subjects as $s)
                            <option value="{{ $s->id }}" @selected(old('subject_id', $question->subject_id) == $s->id)>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Topic --}}
                <div class="form-group col-12 col-md-6">
                    <label for="topic">Topic</label>
                    <input type="text" name="topic" id="topic"
                           class="form-control @error('topic') is-invalid @enderror"
                           value="{{ old('topic', $question->topic) }}" placeholder="e.g. Jean Piaget">
                    @error('topic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Question --}}
            <div class="form-group">
                <label for="question">Question <span class="text-danger">*</span></label>
                <textarea name="question" id="question" rows="3"
                          class="form-control @error('question') is-invalid @enderror" required>{{ old('question', $question->question) }}</textarea>
                @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Options --}}
            <label class="d-block">
                Options <span class="text-danger">*</span>
                <small class="text-muted">(tick the radio button of the correct answer)</small>
            </label>
            @php $answer = (int) old('answer', $question->answer ?? 0); @endphp
            <div class="form-row">
                @foreach (range(0, 3) as $i)
                    <div class="form-group col-12 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="answer" value="{{ $i }}"
                                           id="answer{{ $i }}" @checked($answer === $i) required>
                                    <label for="answer{{ $i }}" class="mb-0 ml-2 font-weight-bold">{{ chr(65 + $i) }}</label>
                                </div>
                            </div>
                            <input type="text" name="options[{{ $i }}]"
                                   class="form-control @error("options.$i") is-invalid @enderror"
                                   placeholder="Option {{ chr(65 + $i) }}" required
                                   value="{{ old("options.$i", $question->options[$i] ?? '') }}">
                            @error("options.$i")<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Explanation --}}
            <div class="form-group">
                <label for="explanation">Explanation</label>
                <textarea name="explanation" id="explanation" rows="3"
                          class="form-control @error('explanation') is-invalid @enderror">{{ old('explanation', $question->explanation) }}</textarea>
                @error('explanation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Buttons: stacked full-width on phones, inline on larger screens --}}
            <div class="d-flex flex-column flex-sm-row">
                <button type="submit" class="btn btn-primary px-4 mb-2 mb-sm-0 mr-sm-2">
                    {{ $isEdit ? 'Update' : 'Save' }}
                </button>
                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection