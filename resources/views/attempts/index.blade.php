@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-6xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">My Attempts</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Question ID</th>
                    <th class="p-3 text-left">Selected</th>
                    <th class="p-3 text-left">Correct?</th>
                    <th class="p-3 text-left">When</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attempts as $a)
                <tr class="border-t">
                    <td class="p-3">{{ $a->id }}</td>
                    <td class="p-3">{{ $a->subject->name ?? '-' }}</td>
                    <td class="p-3">{{ $a->question_id }}</td>
                    <td class="p-3">{{ $a->selected }}</td>
                    <td class="p-3">
                        @if($a->is_correct)
                            <span class="text-green-600 font-semibold">Yes</span>
                        @else
                            <span class="text-red-600 font-semibold">No</span>
                        @endif
                    </td>
                    <td class="p-3 text-sm text-gray-500">{{ $a->created_at }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('attempts.show', $a) }}" class="text-blue-600">View</a>
                        <form action="{{ route('attempts.destroy', $a) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this attempt?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $attempts->links() }}</div>
    </div>
</x-app-layout>
