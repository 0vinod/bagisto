@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Create Shipping</h5>
        <div class="card-body">
            <form method="post" action="{{ route('shipping_policy.create_or_update', $shipping?->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $shipping->description ?? old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group mb-3">
                        <button class="btn btn-success" type="submit">  {{ $shipping->exist ? 'Update' : 'Create' }}</button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
