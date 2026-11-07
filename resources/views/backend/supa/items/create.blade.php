@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">New Syllabus Item</h1>

        <form action="{{ route('items.store') }}" method="POST" class="card shadow-sm p-4">
            @csrf
            @include('backend.supa.items._form', ['item' => null, 'selectedTopic' => $selectedTopic])
            <button class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
@endsection
