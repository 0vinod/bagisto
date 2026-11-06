@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <a href="{{ route('attempts.index') }}" class="text-primary text-decoration-none d-inline-block mb-3">&larr; Back</a>

        <div class="card shadow-sm mt-2">
            <div class="card-body">
                <h1 class="h3 fw-bold mb-3">Attempt #{{ $attempt->id }}</h1>
                <p class="mb-2"><strong>Subject:</strong> {{ $attempt->subject->name ?? '-' }}</p>
                <p class="mb-2"><strong>Question ID:</strong> {{ $attempt->question_id }}</p>
                <p class="mb-2"><strong>Selected option:</strong> {{ $attempt->selected }}</p>
                <p class="mb-2"><strong>Correct:</strong>
                    @if($attempt->is_correct)
                        <span class="text-success fw-semibold">Yes</span>
                    @else
                        <span class="text-danger fw-semibold">No</span>
                    @endif
                </p>
                <p class="mb-0"><strong>When:</strong> {{ $attempt->created_at }}</p>
            </div>
        </div>
    </div>
@endsection
