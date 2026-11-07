@extends('backend.layouts.master')

@section('main-content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h1 class="h3 fw-bold mb-4">New Syllabus Topic</h1>

                <form action="{{ route('topics.store') }}" method="POST"
                    class="bg-white p-4 shadow rounded">
                    @csrf

                    @include('backend.supa.topics._form', ['topic' => null])

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection