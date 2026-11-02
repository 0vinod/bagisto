<x-app-layout>
    <div class="max-w-2xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">New Syllabus Item</h1>

        <form action="{{ route('items.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf
            @include('items._form', ['item' => null, 'selectedTopic' => $selectedTopic])
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
