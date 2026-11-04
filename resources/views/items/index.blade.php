@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold mb-0">Syllabus Items</h1>
            <a href="{{ route('items.create') }}" class="btn btn-primary">+ New Item</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Subject</th>
                            <th class="text-start">Topic</th>
                            <th class="text-start">Heading</th>
                            <th class="text-start">Order</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->topic->subject->name ?? '-' }}</td>
                                <td>{{ $item->topic->name ?? '-' }}</td>
                                <td class="fw-semibold">{{ $item->heading }}</td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('items.show', $item) }}" class="text-primary text-decoration-none">View</a>
                                        <a href="{{ route('items.edit', $item) }}" class="text-warning text-decoration-none">Edit</a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this item?')">
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
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
@endsection
