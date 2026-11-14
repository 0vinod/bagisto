@extends('backend.layouts.master')

@section('main-content')
@php
    $subject = $note->subject;
    $color   = $subject->color ?? '#6366f1';
@endphp

<style>
    .icon-btn {
        width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 10px; border: 0; transition: all .15s;
    }
    .icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.15); text-decoration: none; }
    .icon-btn.edit   { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover   { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
    .stat-chip {
        display: inline-flex; align-items: center; padding: .3rem .8rem; border-radius: 50rem;
        background: #fff; border: 1px solid #e3e6f0; font-size: .8rem; font-weight: 600; color: #5a5c69;
    }
    .order-badge {
        width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }
    .sec-card { border-radius: 14px; border: 1px solid #e3e6f0; transition: box-shadow .15s; }
    .sec-card:hover { box-shadow: 0 6px 16px rgba(0,0,0,.08); }
    .sec-img { width: 100%; max-height: 260px; object-fit: contain; border-radius: 10px; background: #f8f9fc; }
    .bullets { list-style: none; padding: 0; margin: 0; }
    .bullets li { position: relative; padding: 3px 0 3px 20px; font-size: .92rem; }
    .bullets li:before {
        content: ""; position: absolute; left: 2px; top: 11px; width: 8px; height: 8px;
        border-radius: 50%; background: var(--c);
    }
</style>

<div class="container py-4" style="max-width: 920px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: .5rem;">
        <a href="{{ route('notes.index') }}" class="small font-weight-bold text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Notes
        </a>
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="fas fa-pen mr-1"></i> Edit Note
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    @endif

    {{-- Hero --}}
    <div class="card shadow border-0 mb-4" style="border-radius: 16px; overflow: hidden; border-left: 6px solid {{ $color }} !important;">
        @if($note->image_url)
            <img src="{{ $note->image_url }}" alt="" style="width:100%; height:auto; display:block;" onerror="this.remove()">
        @endif
        <div class="card-body p-4" style="background: {{ $color }}12;">
            <div class="d-flex align-items-center" style="gap: 1rem;">
                @if($note->icon_url)
                    <img src="{{ $note->icon_url }}" alt="" style="width:56px;height:56px;object-fit:contain;border-radius:14px;" onerror="this.remove()">
                @else
                    <div style="width:56px;height:56px;border-radius:14px;font-size:1.8rem;background:{{ $color }}25;display:flex;align-items:center;justify-content:center;">
                        {{ $subject->emoji ?? '📒' }}
                    </div>
                @endif
                <div>
                    <div class="small text-uppercase font-weight-bold" style="color: {{ $color }};">
                        <i class="fas fa-book-open mr-1"></i>{{ $subject->name ?? 'No Subject' }}
                    </div>
                    <h1 class="h3 font-weight-bold text-gray-800 mb-0">{{ $note->title }}</h1>
                </div>
            </div>
            @if($note->short_notes)
                <p class="text-gray-700 mt-3 mb-0"><i class="fas fa-align-left mr-2 text-muted"></i>{{ $note->short_notes }}</p>
            @endif
            <div class="d-flex flex-wrap mt-3" style="gap: .5rem;">
                <span class="stat-chip"><i class="fas fa-layer-group mr-1" style="color: {{ $color }};"></i>{{ $note->points->count() }} {{ \Illuminate\Support\Str::plural('section', $note->points->count()) }}</span>
                <span class="stat-chip"><i class="fas fa-sort-numeric-down mr-1" style="color: {{ $color }};"></i>Order {{ $note->sort_order }}</span>
            </div>
        </div>
    </div>

    {{-- Sections --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 font-weight-bold text-gray-800 mb-0">
            <i class="fas fa-layer-group mr-2" style="color: {{ $color }};"></i>Sections
            <span class="badge badge-pill text-white ml-1" style="background: {{ $color }};">{{ $note->points->count() }}</span>
        </h2>
        <a href="{{ route('note-points.create', ['note_id' => $note->id]) }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-plus mr-1"></i> Add Section
        </a>
    </div>

    @forelse($note->points as $p)
        <div class="card sec-card mb-3" style="--c: {{ $color }};">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start" style="gap: .75rem;">
                    <div class="d-flex" style="gap: .75rem;">
                        <span class="order-badge" style="background: {{ $color }}22; color: {{ $color }};">{{ $p->sort_order }}</span>
                        <div>
                            <div class="font-weight-bold text-gray-800">{{ $p->heading }}</div>
                            @if($p->sub_headings)
                                <div class="small font-weight-bold" style="color: {{ $color }};">{{ $p->sub_headings }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="d-inline-flex" style="gap: .4rem;">
                        <a href="{{ route('note-points.edit', $p) }}" class="icon-btn edit" title="Edit section"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('note-points.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this section?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn delete" title="Delete section"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>

                @if($p->image_url)
                    <img src="{{ $p->image_url }}" class="sec-img mt-3" alt="" onerror="this.remove()">
                @endif

                @if(!empty($p->points))
                    <ul class="bullets mt-3">
                        @foreach($p->points as $pt)<li>{{ $pt }}</li>@endforeach
                    </ul>
                @endif
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="text-center py-5">
                <div style="font-size: 3rem;">🗒️</div>
                <p class="text-muted mt-2 mb-3">No sections yet. Add the first one!</p>
                <a href="{{ route('note-points.create', ['note_id' => $note->id]) }}" class="btn btn-success rounded-pill px-4">
                    <i class="fas fa-plus mr-1"></i> Add the first section
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection