@extends('backend.layouts.master')
@section('main-content')
<div class="container">
    <div class="max-w-6xl mx-auto py-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Syllabus Topics</h1>
            <a href="{{ route('topics.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New Topic</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Topic</th>
                    <th class="p-3 text-left">Detail</th>
                    <th class="p-3 text-left">Items</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topics as $topic)
                <tr class="border-t">
                    <td class="p-3">{{ $topic->subject->emoji ?? '' }} {{ $topic->subject->name ?? '-' }}</td>
                    <td class="p-3 font-semibold">{{ $topic->name }}</td>
                    <td class="p-3 text-gray-600 text-sm">{{ $topic->detail }}</td>
                    <td class="p-3">{{ $topic->items->count() }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('topics.show', $topic) }}" class="text-blue-600">View</a>
                        <a href="{{ route('topics.edit', $topic) }}" class="text-yellow-600">Edit</a>
                        <form action="{{ route('topics.destroy', $topic) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this topic?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $topics->links() }}</div>
    </div>
    </div>

    @endsection
