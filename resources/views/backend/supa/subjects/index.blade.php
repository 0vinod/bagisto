@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-6xl mx-auto py-6 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Subjects</h1>
            <a href="{{ route('subjects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Subject
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">Sort</th>
                        <th class="p-4 font-semibold text-gray-600">Emoji</th>
                        <th class="p-4 font-semibold text-gray-600">Name</th>
                        <th class="p-4 font-semibold text-gray-600">Short Note</th>
                        <th class="p-4 font-semibold text-gray-600">Color</th>
                        <th class="p-4 font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-gray-500">{{ $subject->sort_order }}</td>
                        <td class="p-4 text-2xl">{{ $subject->emoji }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $subject->name }}</td>
                        <td class="p-4 text-gray-600 text-sm">{{ $subject->short_note }}</td>
                        <td class="p-4">
                            <span class="inline-block w-6 h-6 rounded-full border border-gray-300" style="background-color: {{ $subject->color ?? '#6366f1' }}"></span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline" onsubmit="return confirm('Delete this subject? All related data will also be deleted.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">No subjects found. Click "+ Add Subject" to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection