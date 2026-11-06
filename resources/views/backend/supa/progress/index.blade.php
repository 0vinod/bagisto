@extends('backend.layouts.master')
@section('main-content')
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">My Syllabus Progress</h1>

        @php
            $total = $items->count();
            $done  = count($doneIds);
            $pct   = $total ? round($done / $total * 100) : 0;
        @endphp

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-semibold">Completed</span>
                    <span>{{ $done }} / {{ $total }} ({{ $pct }}%)</span>
                </div>
                <div class="progress" role="progressbar" aria-label="Syllabus progress" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        </div>

        @foreach($items->groupBy('topic.id') as $topicId => $topicItems)
            @php $topic = $topicItems->first()->topic; @endphp
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5 fw-semibold mb-3">
                        {{ $topic->subject->name ?? '' }} → {{ $topic->name }}
                    </h2>
                    <ul class="list-unstyled mb-0">
                        @foreach($topicItems as $item)
                            <li class="d-flex align-items-center gap-2 mb-2">
                                <input type="checkbox"
                                       class="progress-toggle"
                                       data-item="{{ $item->id }}"
                                       @checked(in_array($item->id, $doneIds))>
                                <span>{{ $item->heading }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
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
@endsection
