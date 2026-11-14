@extends('backend.layouts.master')

@section('main-content')
<style>
    .subject-table tbody tr { transition: background .15s, transform .15s; }
    .subject-table tbody tr:hover { background: #f8f9fc; }
    .emoji-tile {
        width: 46px; height: 46px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 14px; font-size: 1.5rem;
    }
    .color-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .25rem .65rem; border-radius: 50rem;
        background: #f1f3f9; font-size: .75rem; color: #5a5c69;
        font-family: monospace;
    }
    .color-chip .dot {
        width: 14px; height: 14px; border-radius: 50%;
        border: 2px solid #fff; box-shadow: 0 0 0 1px #d1d3e2;
    }
    .sort-badge {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #eaecf4; color: #4e73df; font-weight: 700; font-size: .85rem;
    }
    .icon-btn {
        width: 36px; height: 36px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; border: 0; transition: all .15s;
    }
    .icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.15); }
    .icon-btn.edit   { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover   { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
</style>

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h1 class="h3 font-weight-bold text-gray-800 mb-1">
                <i class="fas fa-book-open text-primary mr-2"></i>Subjects
            </h1>
            <p class="text-muted mb-0 small">
                {{ $subjects->count() }} {{ \Illuminate\Support\Str::plural('subject', $subjects->count()) }} in your syllabus
            </p>
        </div>

        <a href="{{ route('subjects.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-plus mr-1"></i> Add Subject
        </a>
    </div>

    {{-- Success alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table subject-table align-middle mb-0">
                <thead style="background:#f8f9fc;">
                    <tr class="text-uppercase small text-muted">
                       
                     
                        <th class="p-3 border-0"><i class="fas fa-tag mr-1"></i> Name</th>
                        <th class="p-3 border-0"><i class="fas fa-sticky-note mr-1"></i> Short Note</th>
                        <th class="p-3 border-0"><i class="fas fa-palette mr-1"></i> Color</th>
                        <th class="p-3 border-0 text-right"><i class="fas fa-cog mr-1"></i> Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($subjects as $subject)
                        @php $color = $subject->color ?? '#6366f1'; @endphp
                        <tr>
                         

                            <td class="p-3 align-middle font-weight-bold text-gray-800">
                                {{ $subject->name }} <br>
                                
                                <div class="d-flex"></div>
                                 <span class="emoji-tile" style="background: {{ $color }}22;">
                                    {{ $subject->emoji ?: '📘' }}
                                </span>
                                       <span class="color-chip" style="margin-left:2px">
                                           {{ $subject->weightage }}
                                           </span>
                                
                                </div>
                            </td>

                            <td class="p-3 align-middle text-muted small" style="max-width: 280px;">
                                {{ \Illuminate\Support\Str::limit($subject->short_note, 70) ?: '—' }}
                            </td>

                            <td class="p-3 align-middle">
                                <span class="color-chip">
                                    <span class="dot" style="background: {{ $color }};"></span>
                                    {{ $color }}
                                </span>
                            </td>

                            <td class="p-3 align-middle text-right">
                                <div class="d-inline-flex" style="gap: .5rem;">
                                    <a href="{{ route('subjects.edit', $subject) }}"
                                       class="icon-btn edit" title="Edit subject">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="{{ route('subjects.notes.index', $subject) }}" class="icon-btn view" title="Notes">
                                        <i class="fas fa-sticky-note"></i>
                                    </a>

                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST"
                                          onsubmit="return confirm('Delete this subject? All related data will also be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn delete" title="Delete subject">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="font-size: 3rem;">📚</div>
                                <p class="text-muted mt-2 mb-3">No subjects yet. Start by creating your first one!</p>
                                <a href="{{ route('subjects.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus mr-1"></i> Add Subject
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