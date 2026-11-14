@extends('backend.layouts.master')

@section('main-content')
@php $color = $subject->color ?? '#6366f1'; @endphp
<style>
    .note-card { border-radius: 16px; border-left: 6px solid {{ $color }} !important; transition: all .15s; }
    .note-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.1) !important; }
    .note-thumb { width: 64px; height: 64px; border-radius: 14px; object-fit: cover; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .count-pill { padding: .2rem .7rem; border-radius: 50rem; background: {{ $color }}22; color: {{ $color }};
        font-size: .75rem; font-weight: 700; }
    .icon-btn { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center;
        justify-content: center; border-radius: 10px; border: 0; transition: all .15s; }
    .icon-btn:hover { transform: translateY(-2px); text-decoration: none; }
    .icon-btn.edit { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
</style>

<div class="container py-4" style="max-width: 920px;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: .5rem;">
        <div>
            <a href="{{ route('subjects.index') }}" class="small font-weight-bold text-decoration-none">
                <i class="fas fa-arrow-left mr-1"></i> Back to Subjects
            </a>
            <h1 class="h3 font-weight-bold text-gray-800 mt-2 mb-0">
                <span style="font-size:1.6rem;">{{ $subject->emoji ?? '📘' }}</span> {{ $subject->name }}
                <span class="text-muted font-weight-normal">· Notes</span>
            </h1>
        </div>
        <a href="{{ route('subjects.notes.create', $subject) }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-plus mr-1"></i> New Note
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @forelse($notes as $note)
        <div class="card note-card shadow-sm border-0 mb-3">
            <div class="card-body p-3 d-flex align-items-center" style="gap: 1rem;">
                <a href="{{ route('notes.points.index', $note) }}" class="d-flex align-items-center flex-grow-1 text-decoration-none" style="gap: 1rem; min-width: 0;">
                    @if($note->image_url)
                        <img src="{{ $note->image_url }}" class="note-thumb" alt=""
                             onerror="this.outerHTML='<span class=&quot;note-thumb&quot; style=&quot;background:{{ $color }}22&quot;>{{ $subject->emoji ?? '📒' }}</span>'">
                    @else
                        <span class="note-thumb" style="background: {{ $color }}22;">{{ $subject->emoji ?? '📒' }}</span>
                    @endif
                    <div style="min-width:0;">
                        <div class="font-weight-bold text-gray-800">{{ $note->title }}   
                                  
                                       <span class="color-chip" style="margin-left:2px">
                                           {{ $note->weightage }}
                                           </span>
                                
                              </div>
                        <div class="small text-muted">{{ \Illuminate\Support\Str::limit($note->short_notes, 80) ?: 'No short notes' }}</div>
                        <span class="count-pill mt-1 d-inline-block"><i class="fas fa-layer-group mr-1"></i>{{ $note->points_count }} sections</span>
                    </div>
                </a>
                <div class="d-inline-flex" style="gap: .4rem;">
                    <a href="{{ route('notes.edit', $note) }}" class="icon-btn edit" title="Edit"><i class="fas fa-pen"></i></a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note and all its sections?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="icon-btn delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0 text-center py-5" style="border-radius:16px;">
            <div style="font-size:3rem;">📒</div>
            <p class="text-muted mt-2 mb-3">No notes for {{ $subject->name }} yet.</p>
            <div><a href="{{ route('subjects.notes.create', $subject) }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus mr-1"></i> New Note</a></div>
        </div>
    @endforelse
</div>
@endsection