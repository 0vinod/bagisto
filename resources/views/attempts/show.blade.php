@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-2xl mx-auto py-6">
        <a href="{{ route('attempts.index') }}" class="text-blue-600">&larr; Back</a>

        <div class="bg-white p-6 shadow rounded mt-4 space-y-2">
            <h1 class="text-xl font-bold">Attempt #{{ $attempt->id }}</h1>
            <p><strong>Subject:</strong> {{ $attempt->subject->name ?? '-' }}</p>
            <p><strong>Question ID:</strong> {{ $attempt->question_id }}</p>
            <p><strong>Selected option:</strong> {{ $attempt->selected }}</p>
            <p><strong>Correct:</strong>
                @if($attempt->is_correct)
                    <span class="text-green-600">Yes</span>
                @else
                    <span class="text-red-600">No</span>
                @endif
            </p>
            <p><strong>When:</strong> {{ $attempt->created_at }}</p>
        </div>
    </div>
</x-app-layout>
