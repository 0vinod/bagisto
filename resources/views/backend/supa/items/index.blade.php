@extends('backend.layouts.master')

@section('main-content')
<style>
    .subject-header td { transition: background .15s; }
    .subject-header:hover td { filter: brightness(.97); }
    .item-row { transition: background .15s; }
    .item-row:hover { background: #f8f9fc; }
    .topic-pill {
        display: inline-flex; align-items: center;
        padding: .2rem .65rem; border-radius: 50rem;
        background: #eaecf4; color: #4e73df;
        font-size: .75rem; font-weight: 600;
    }
    .sort-badge {
        width: 30px; height: 30px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #eaecf4; color: #4e73df; font-weight: 700; font-size: .8rem;
    }
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
                <i class="fas fa-list-ul text-primary mr-2"></i>Syllabus Items
            </h1>
            <p class="text-muted mb-0 small">{{ $items->total() }} items across your syllabus</p>
        </div>

        <div class="d-flex" style="gap: .5rem;">
            <button type="button" id="expandAll" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-expand-alt mr-1"></i> Expand
            </button>
            <button type="button" id="collapseAll" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-compress-alt mr-1"></i> Collapse
            </button>
            <a href="{{ route('items.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-plus mr-1"></i> New Item
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @php
        $grouped = $items->getCollection()->groupBy(fn($i) => $i->topic->subject_id ?? 0);
    @endphp

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead style="background:#f8f9fc;">
                    <tr class="text-uppercase small text-muted">
                        <th class="p-3 border-0"><i class="fas fa-folder-open mr-1"></i> Topic</th>
                        <th class="p-3 border-0"><i class="fas fa-heading mr-1"></i> Heading</th>
                        <th class="p-3 border-0"><i class="fas fa-sort-numeric-down mr-1"></i> Order</th>
                        <th class="p-3 border-0 text-right"><i class="fas fa-cog mr-1"></i> Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($grouped as $subjectId => $subjectItems)
                        @php
                            $subject = $subjectItems->first()->topic->subject ?? null;
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
                                      style="background: {{ $color }};">{{ $subjectItems->count() }}</span>
                            </td>
                        </tr>

                        {{-- Items --}}
                        @foreach ($subjectItems->sortBy([['topic.name', 'asc'], ['sort_order', 'asc']]) as $item)
                            <tr class="item-row subject-{{ $subjectId }}">
                                <td class="p-3 pl-4">
                                    <span class="topic-pill">
                                        <i class="fas fa-folder mr-1"></i>{{ $item->topic->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="p-3 font-weight-bold text-gray-800">
                                    {{ $item->heading }}
                                </td>

                                <td class="p-3">
                                    <span class="sort-badge">{{ $item->sort_order }}</span>
                                </td>

                                <td class="p-3 text-right">
                                    <div class="d-inline-flex" style="gap: .4rem;">
                                        <a href="{{ route('items.show', $item) }}" class="icon-btn view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('items.edit', $item) }}" class="icon-btn edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Delete this item?')">
                                            @csrf @method('DELETE')
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
                                <p class="text-muted mt-2 mb-3">No items yet. Create your first one!</p>
                                <a href="{{ route('items.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus mr-1"></i> New Item
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
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