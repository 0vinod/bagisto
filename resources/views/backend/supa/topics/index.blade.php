@extends('backend.layouts.master')

@section('main-content')
<style>
    .subject-header td { transition: filter .15s; }
    .subject-header:hover td { filter: brightness(.97); }
    .topic-row { transition: background .15s; }
    .topic-row:hover { background: #f8f9fc; }
    .topic-icon {
        width: 36px; height: 36px; border-radius: 10px;
        display: inline-flex; align-items: center; justify-content: center;
        background: #eaecf4; color: #4e73df; font-size: .9rem;
    }
    .count-pill {
        display: inline-flex; align-items: center;
        padding: .2rem .7rem; border-radius: 50rem;
        background: #e8f0fe; color: #4e73df;
        font-size: .75rem; font-weight: 700;
    }
    .count-pill.zero { background: #f1f3f9; color: #a0a3b5; }
    .icon-btn {
        width: 34px; height: 34px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; border: 0; transition: all .15s;
    }
    .icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.15); text-decoration: none; }
    .icon-btn.view   { background: #e0f7fa; color: #17a2b8; }
    .icon-btn.view:hover   { background: #17a2b8; color: #fff; }
    .icon-btn.edit   { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover   { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
</style>

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: .5rem;">
        <div>
            <h1 class="h3 font-weight-bold text-gray-800 mb-1">
                <i class="fas fa-folder-open text-primary mr-2"></i>Syllabus Topics
            </h1>
            <p class="text-muted mb-0 small">{{ $topics->total() }} topics across your subjects</p>
        </div>

        <div class="d-flex" style="gap: .5rem;">
            <button type="button" id="expandAll" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-expand-alt mr-1"></i> Expand
            </button>
            <button type="button" id="collapseAll" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-compress-alt mr-1"></i> Collapse
            </button>
            <a href="{{ route('topics.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-plus mr-1"></i> New Topic
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @php
        $grouped = $topics->getCollection()->groupBy(fn($t) => $t->subject_id ?? 0);
    @endphp

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead style="background:#f8f9fc;">
                    <tr class="text-uppercase small text-muted">
                        <th class="p-3 border-0"><i class="fas fa-bookmark mr-1"></i> Topic</th>
                        <th class="p-3 border-0"><i class="fas fa-align-left mr-1"></i> Detail</th>
                        <th class="p-3 border-0"><i class="fas fa-list-ul mr-1"></i> Items</th>
                        <th class="p-3 border-0 text-right"><i class="fas fa-cog mr-1"></i> Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($grouped as $subjectId => $subjectTopics)
                        @php
                            $subject = $subjectTopics->first()->subject;
                            $color   = $subject->color ?? '#6366f1';
                        @endphp

                        {{-- Subject header --}}
                        <tr class="subject-header" data-group="subject-{{ $subjectId }}"
                            style="cursor:pointer; user-select:none;">
                            <td colspan="4" class="p-3 font-weight-bold border-0"
                                style="background: {{ $color }}18; border-left: 5px solid {{ $color }} !important;">
                                <i class="fas fa-chevron-down toggle-icon mr-2"
                                   style="transition: transform .2s; color: {{ $color }};"></i>
                                <span style="font-size:1.2rem;">{{ $subject->emoji ?? '📘' }}</span>
                                {{ $subject->name ?? 'No Subject' }}
                                <span class="badge badge-pill text-white ml-2"
                                      style="background: {{ $color }};">{{ $subjectTopics->count() }}</span>
                            </td>
                        </tr>

                        {{-- Topics --}}
                        @foreach($subjectTopics as $topic)
                            @php $itemCount = $topic->items_count ?? $topic->items->count(); @endphp
                            <tr class="topic-row subject-{{ $subjectId }}">
                                <td class="p-3 pl-4">
                                    <div class="d-flex align-items-center" style="gap: .75rem;">
                                        <span class="topic-icon"
                                              style="background: {{ $color }}22; color: {{ $color }};">
                                            <i class="fas fa-bookmark"></i>
                                        </span>
                                        <span class="font-weight-bold text-gray-800">{{ $topic->name }}</span>
                                    </div>
                                </td>

                                <td class="p-3 text-muted small" style="max-width: 320px;">
                                    {{ \Illuminate\Support\Str::limit($topic->detail, 80) ?: '—' }}
                                </td>

                                <td class="p-3">
                                    <span class="count-pill {{ $itemCount ? '' : 'zero' }}">
                                        <i class="fas fa-list-ul mr-1"></i>{{ $itemCount }}
                                    </span>
                                </td>

                                <td class="p-3 text-right">
                                    <div class="d-inline-flex" style="gap: .4rem;">
                                        <a href="{{ route('topics.show', $topic) }}" class="icon-btn view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('topics.edit', $topic) }}" class="icon-btn edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('topics.destroy', $topic) }}" method="POST"
                                              onsubmit="return confirm('Delete this topic?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div style="font-size: 3rem;">🗂️</div>
                                <p class="text-muted mt-2 mb-3">No topics yet. Create your first one!</p>
                                <a href="{{ route('topics.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus mr-1"></i> New Topic
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-4">{{ $topics->links() }}</div>
</div>

<script>
(function () {
    function setGroup(header, collapse) {
        document.querySelectorAll('.' + header.dataset.group).forEach(function (r) {
            r.classList.toggle('d-none', collapse);
        });
        header.querySelector('.toggle-icon').style.transform =
            collapse ? 'rotate(-90deg)' : 'rotate(0deg)';
        header.dataset.collapsed = collapse ? '1' : '0';
    }

    var headers = document.querySelectorAll('.subject-header');

    headers.forEach(function (h) {
        h.addEventListener('click', function () {
            setGroup(h, h.dataset.collapsed !== '1');
        });
    });

    document.getElementById('expandAll').addEventListener('click', function () {
        headers.forEach(function (h) { setGroup(h, false); });
    });
    document.getElementById('collapseAll').addEventListener('click', function () {
        headers.forEach(function (h) { setGroup(h, true); });
    });
})();
</script>
@endsection