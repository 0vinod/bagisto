@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-4xl mx-auto py-6">
        <a href="{{ route('topics.index') }}" class="text-blue-600">&larr; Back</a>

        <div class="bg-white p-6 shadow rounded mt-4">
            <h1 class="text-2xl font-bold">{{ $topic->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $topic->detail }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Subject: {{ $topic->subject->emoji ?? '' }} {{ $topic->subject->name ?? '-' }}
            </p>
        </div>

        <div class="bg-white p-6 shadow rounded mt-4">
            <div class="flex justify-between mb-3">
                <h2 class="text-lg font-semibold">Items ({{ $topic->items->count() }})</h2>
                <a href="{{ route('items.create', ['topic_id' => $topic->id]) }}"
                   class="bg-green-600 text-white px-3 py-1 rounded text-sm">+ Add Item</a>
            </div>

            <ul class="divide-y">
                @forelse($topic->items as $item)
                    <li class="py-2 flex justify-between">
                        <span>{{ $item->sort_order }}. {{ $item->heading }}</span>
                        <span class="space-x-2 text-sm">
                            <a href="{{ route('items.edit', $item) }}" class="text-yellow-600">Edit</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete item?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">No items yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
