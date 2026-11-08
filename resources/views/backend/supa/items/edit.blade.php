@extends('backend.layouts.master')

@section('main-content')
<div class="container py-4" style="max-width: 920px;">

    <div class="mb-4">
        <a href="{{ route('items.index') }}" class="small font-weight-bold text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Items
        </a>
        <h1 class="h3 font-weight-bold text-gray-800 mt-2 mb-0">
            <i class="fas fa-pen text-primary mr-2"></i>Edit Item
            <span class="text-muted font-weight-normal">· {{ \Illuminate\Support\Str::limit($item->heading, 40) }}</span>
        </h1>
    </div>

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4">
            <form action="{{ route('items.update', $item) }}" method="POST">
                @csrf @method('PUT')
                @include('backend.supa.items._form', ['item' => $item, 'selectedTopic' => $item->topic_id])

                <hr class="my-4">

                <div class="d-flex justify-content-end" style="gap: .5rem;">
                    <a href="{{ route('items.index') }}" class="btn btn-light rounded-pill px-4">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save mr-1"></i> Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection