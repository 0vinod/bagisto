@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-2xl mx-auto py-6 px-4">
        <div class="mb-6">
            <a href="{{ route('subjects.index') }}" class="text-indigo-600 hover:underline text-sm font-medium">← Back to Subjects</a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Create Subject</h1>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('subjects.store') }}" method="POST">
                @include('backend.supa.subjects._form')
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                        Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection