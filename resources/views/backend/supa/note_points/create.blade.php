@extends('backend.layouts.master')

@section('main-content')
@php $color = $note->subject->color ?? '#6366f1'; @endphp
<div class="container py-4" style="max-width: 760px;">
    <div class="mb-4">
        <a href="{{ route('notes.show', $note) }}" class="small font-weight-bold text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Note
        </a>
        <h1 class="h3 font-weight-bold text-gray-800 mt-2 mb-2">
            <i class="fas fa-plus-circle text-primary mr-2"></i>New Section
        </h1>
        <span class="badge badge-pill text-white px-3 py-2" style="background: {{ $color }};">
            {{ $note->subject->emoji ?? '📒' }} {{ $note->subject->name ?? '' }} · {{ $note->title }}
        </span>
    </div>

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4">
          <form action="{{ route('notes.points.store', $note) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.supa.note_points._form', ['point' => null])
                <hr class="my-4">
                <div class="d-flex justify-content-end" style="gap: .5rem;">
                    <a href="{{ route('notes.show', $note) }}" class="btn btn-light rounded-pill px-4"><i class="fas fa-times mr-1"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fas fa-save mr-1"></i> Save Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
 