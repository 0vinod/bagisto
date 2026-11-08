@extends('backend.layouts.master')

@section('main-content')
<div class="container py-4" style="max-width: 920px;">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('subjects.index') }}" class="small font-weight-bold text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Subjects
        </a>
        <h1 class="h3 font-weight-bold text-gray-800 mt-2 mb-0">
            <i class="fas fa-plus-circle text-primary mr-2"></i>Create Subject
        </h1>
        <p class="text-muted small mb-0 mt-1">Add a new subject to your syllabus.</p>
    </div>

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4">
            <form action="{{ route('subjects.store') }}" method="POST">
                @include('backend.supa.subjects._form')

                <hr class="my-4">

                <div class="d-flex justify-content-end" style="gap: .5rem;">
                    <a href="{{ route('subjects.index') }}" class="btn btn-light rounded-pill px-4">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save mr-1"></i> Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection