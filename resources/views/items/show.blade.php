@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <a href="{{ route('items.index') }}" class="text-primary text-decoration-none d-inline-block mb-3">&larr; Back</a>

        <div class="card shadow-sm mt-2">
            <div class="card-body">
                <h1 class="h3 fw-bold mb-3">{{ $item->heading }}</h1>
                <p class="text-muted mb-2">
                    {{ $item->topic->subject->name ?? '' }} → {{ $item->topic->name ?? '' }}
                </p>
                <p class="text-secondary small mb-0">Sort order: {{ $item->sort_order }}</p>
            </div>
        </div>
    </div>
@endsection
