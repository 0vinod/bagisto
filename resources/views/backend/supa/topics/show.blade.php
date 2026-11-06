@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <a href="{{ route('topics.index') }}" class="text-primary text-decoration-none">&larr; Back</a>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h1 class="h3 mb-3">{{ $topic->name }}</h1>
                <p class="text-muted mb-2">{{ $topic->detail }}</p>
                <p class="text-secondary small mb-0">
                    Subject: {{ $topic->subject->emoji ?? '' }} {{ $topic->subject->name ?? '-' }}
                </p>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Items ({{ $topic->items->count() }})</h2>
                    <a href="{{ route('items.create', ['topic_id' => $topic->id]) }}"
                       class="btn btn-success btn-sm">+ Add Item</a>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse($topic->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $item->sort_order }}. {{ $item->heading }}</span>
                            <span class="d-flex align-items-center gap-2">
                                <a href="{{ route('items.edit', $item) }}" class="text-warning">Edit</a>
                                <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete item?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger p-0">Delete</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No items yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
