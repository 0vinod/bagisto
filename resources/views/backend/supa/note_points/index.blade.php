@extends('backend.layouts.master')

@section('main-content')
<style>
    .icon-btn {
        width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 10px; border: 0; transition: all .15s;
    }
    .icon-btn:hover { transform: translateY(-2px); text-decoration: none; }
    .icon-btn.edit   { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover   { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
    .sort-badge {
        width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: .8rem;
        background: #eaecf4; color: #4e73df;
    }
</style>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: .5rem;">
        <h1 class="h3 font-weight-bold text-gray-800 mb-0">
            <i class="fas fa-layer-group text-primary mr-2"></i>Note Sections
        </h1>
        <a href="{{ route('notes.points.create', $noteId) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus mr-1"></i> Add Section
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead style="background:#f8f9fc;">
                    <tr class="text-uppercase small text-muted">
                        <th class="p-3 border-0">Order</th>
                        <th class="p-3 border-0">Heading</th>
                        <th class="p-3 border-0">Sub Heading</th>
                        <th class="p-3 border-0">Points</th>
                        <th class="p-3 border-0">Image</th>
                        <th class="p-3 border-0 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($points as $p)
                        <tr>
                            <td class="p-3"><span class="sort-badge">{{ $p->sort_order }}</span></td>
                            <td class="p-3 font-weight-bold text-gray-800">{{ $p->heading }}   <span class="color-chip" style="margin-left:2px">
                                           {{ $p->weightage }}
                                           </span></td>
                            <td class="p-3 text-muted small">{{ $p->sub_headings ?: '—' }}</td>
                            <td class="p-3 small">
                                @if(!empty($p->points))
                                    <ul class="pl-3 mb-0">
                                        @foreach($p->points as $pt)<li>{{ $pt }}</li>@endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="p-3">
                                @if($p->image_url)
                                    <img src="{{ $p->image_url }}" alt="" style="width:60px; height:auto; border-radius:8px;" onerror="this.remove()">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="p-3 text-right">
                                <div class="d-inline-flex" style="gap: .4rem;">
                                    <a href="{{ route('points.edit', $p) }}" class="icon-btn edit" title="Edit"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('points.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this section?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="icon-btn delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="font-size: 3rem;">🗒️</div>
                                <p class="text-muted mt-2 mb-3">No sections yet.</p>
                                <a href="{{ route('notes.points.create', $noteId) }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus mr-1"></i> Add Section
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection