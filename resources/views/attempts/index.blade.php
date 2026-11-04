@extends('backend.layouts.master')
@section('main-content')
<div class="container py-4">
    <h1 class="h3 fw-bold mb-4">My Attempts</h1>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Question ID</th>
                        <th>Selected</th>
                        <th>Correct?</th>
                        <th>When</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attempts as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->subject->name ?? '-' }}</td>
                        <td>{{ $a->question_id }}</td>
                        <td>{{ $a->selected }}</td>
                        <td>
                            @if($a->is_correct)
                                <span class="text-success fw-semibold">Yes</span>
                            @else
                                <span class="text-danger fw-semibold">No</span>
                            @endif
                        </td>
                        <td class="text-secondary small">{{ $a->created_at }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('attempts.show', $a) }}" class="text-primary text-decoration-none">View</a>
                                <form action="{{ route('attempts.destroy', $a) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this attempt?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger p-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $attempts->links() }}</div>
</div>
@endsection
