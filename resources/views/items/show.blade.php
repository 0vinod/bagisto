<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <a href="{{ route('items.index') }}" class="text-blue-600">&larr; Back</a>

        <div class="bg-white p-6 shadow rounded mt-4">
            <h1 class="text-2xl font-bold">{{ $item->heading }}</h1>
            <p class="text-gray-600 mt-1">
                {{ $item->topic->subject->name ?? '' }} → {{ $item->topic->name ?? '' }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Sort order: {{ $item->sort_order }}</p>
        </div>
    </div>
</x-app-layout>
