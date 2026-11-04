@extends('backend.layouts.master')
@section('main-content')
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">My Syllabus Progress</h1>

        @php
            $total = $items->count();
            $done  = count($doneIds);
            $pct   = $total ? round($done / $total * 100) : 0;
        @endphp

        <div class="bg-white p-4 shadow rounded mb-6">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Completed</span>
                <span>{{ $done }} / {{ $total }} ({{ $pct }}%)</span>
            </div>
            <div class="w-full bg-gray-200 rounded h-3">
                <div class="bg-green-500 h-3 rounded" style="width: {{ $pct }}%"></div>
            </div>
        </div>

        @foreach($items->groupBy('topic.id') as $topicId => $topicItems)
            @php $topic = $topicItems->first()->topic; @endphp
            <div class="bg-white p-4 shadow rounded mb-4">
                <h2 class="font-semibold mb-2">
                    {{ $topic->subject->name ?? '' }} → {{ $topic->name }}
                </h2>
                <ul class="space-y-1">
                    @foreach($topicItems as $item)
                        <li class="flex items-center gap-2">
                            <input type="checkbox"
                                   class="progress-toggle"
                                   data-item="{{ $item->id }}"
                                   @checked(in_array($item->id, $doneIds))>
                            <span>{{ $item->heading }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.progress-toggle').forEach(cb => {
            cb.addEventListener('change', async (e) => {
                const itemId = e.target.dataset.item;
                const res = await fetch(`{{ url('progress/toggle') }}/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });
                if (!res.ok) {
                    e.target.checked = !e.target.checked;
                    alert('Failed to update progress');
                } else {
                    // reload to update the progress bar
                    location.reload();
                }
            });
        });
    </script>
</x-app-layout>
