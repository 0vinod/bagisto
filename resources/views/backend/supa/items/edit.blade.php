@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">Edit Item</h1>

        <form action="{{ route('items.update', $item) }}" method="POST" class="card shadow-sm p-4">
            @csrf @method('PUT')
            @include('items._form', ['item' => $item, 'selectedTopic' => $item->topic_id])
            <button class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
