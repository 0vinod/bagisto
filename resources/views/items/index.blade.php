<x-app-layout>
    <div class="max-w-6xl mx-auto py-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Syllabus Items</h1>
            <a href="{{ route('items.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">+ New Item</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Topic</th>
                    <th class="p-3 text-left">Heading</th>
                    <th class="p-3 text-left">Order</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="border-t">
                    <td class="p-3">{{ $item->topic->subject->name ?? '-' }}</td>
                    <td class="p-3">{{ $item->topic->name ?? '-' }}</td>
                    <td class="p-3 font-semibold">{{ $item->heading }}</td>
                    <td class="p-3">{{ $item->sort_order }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('items.show', $item) }}" class="text-blue-600">View</a>
                        <a href="{{ route('items.edit', $item) }}" class="text-yellow-600">Edit</a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this item?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</x-app-layout>
