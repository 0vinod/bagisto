@extends('backend.layouts.master')

@section('main-content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Syllabus Topics</h1>

        <a href="{{ route('topics.create') }}" class="btn btn-primary">
            + New Topic
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="p-3 text-start">Subject</th>
                        <th class="p-3 text-start">Topic</th>
                        <th class="p-3 text-start">Detail</th>
                        <th class="p-3 text-start">Items</th>
                        <th class="p-3 text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($topics as $topic)
                        <tr>
                            <td class="p-3">
                                {{ $topic->subject->emoji ?? '' }}
                                {{ $topic->subject->name ?? '-' }}
                            </td>

                            <td class="p-3 fw-semibold">
                                {{ $topic->name }}
                            </td>

                            <td class="p-3 text-secondary small">
                                {{ $topic->detail }}
                            </td>

                            <td class="p-3">
                                {{ $topic->items->count() }}
                            </td>

                            <td class="p-3 text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('topics.show', $topic) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                    <a href="{{ route('topics.edit', $topic) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('topics.destroy', $topic) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this topic?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No syllabus topics found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $topics->links() }}
    </div>

</div>
@endsection