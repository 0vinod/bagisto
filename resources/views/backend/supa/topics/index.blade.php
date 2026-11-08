@extends('backend.layouts.master')

@section('main-content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Syllabus Topics</h1>

        <div class="d-flex gap-2">
            <button type="button" id="expandAll" class="btn btn-outline-secondary">Expand all</button>
            <button type="button" id="collapseAll" class="btn btn-outline-secondary">Collapse all</button>
            <a href="{{ route('topics.create') }}" class="btn btn-primary">
                + New Topic
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $grouped = $topics->getCollection()->groupBy(fn($t) => $t->subject_id ?? 0);
    @endphp

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="p-3 text-start">Topic</th>
                        <th class="p-3 text-start">Detail</th>
                        <th class="p-3 text-start">Items</th>
                        <th class="p-3 text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($grouped as $subjectId => $subjectTopics)
                        @php $subject = $subjectTopics->first()->subject; @endphp

                        {{-- Clickable subject header row --}}
                        <tr class="table-secondary subject-header"
                            data-group="subject-{{ $subjectId }}"
                            style="cursor:pointer; user-select:none;">
                            <td colspan="4" class="p-3 fw-bold">
                                <i class="fas fa-chevron-down toggle-icon me-2"
                                   style="transition: transform .2s;"></i>
                                {{ $subject->emoji ?? '' }}
                                {{ $subject->name ?? 'No Subject' }}
                                <span class="badge bg-dark text-white ms-2">{{ $subjectTopics->count() }}</span>
                            </td>
                        </tr>

                        {{-- Topics under this subject --}}
                        @foreach($subjectTopics as $topic)
                            <tr class="subject-row subject-{{ $subjectId }}">
                                <td class="p-3 ps-4 fw-semibold">
                                    {{ $topic->name }}
                                </td>

                                <td class="p-3 text-secondary small">
                                    {{ $topic->detail }}
                                </td>

                                <td class="p-3">
                                    {{ $topic->items->count() }}
                                </td>

                                <td class="p-3 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('topics.show', $topic) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        <a href="{{ route('topics.edit', $topic) }}"
                                           class="btn btn-sm btn-outline-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('topics.destroy', $topic) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this topic?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No syllabus topics found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $topics->links() }}
    </div>

</div>

<script>
(function () {
    function setGroup(header, collapse) {
        var rows = document.querySelectorAll('.' + header.dataset.group);
        rows.forEach(function (r) { r.classList.toggle('d-none', collapse); });
        header.querySelector('.toggle-icon').style.transform =
            collapse ? 'rotate(-90deg)' : 'rotate(0deg)';
        header.dataset.collapsed = collapse ? '1' : '0';
    }

    document.querySelectorAll('.subject-header').forEach(function (header) {
        header.addEventListener('click', function () {
            setGroup(header, header.dataset.collapsed !== '1');
        });
    });

    document.getElementById('expandAll').addEventListener('click', function () {
        document.querySelectorAll('.subject-header').forEach(function (h) { setGroup(h, false); });
    });

    document.getElementById('collapseAll').addEventListener('click', function () {
        document.querySelectorAll('.subject-header').forEach(function (h) { setGroup(h, true); });
    });
})();
</script>
@endsection