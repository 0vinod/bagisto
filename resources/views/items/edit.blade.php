<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Item</h1>

        <form action="{{ route('items.update', $item) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf @method('PUT')
            @include('items._form', ['item' => $item, 'selectedTopic' => $item->topic_id])
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
