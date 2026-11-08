@extends('backend.layouts.master')

@section('main-content')
@php
    $subject = $topic->subject;
    $color   = $subject->color ?? '#6366f1';
    $items   = $topic->items->sortBy('sort_order');
@endphp

<style>
    .hero-tile {
        width: 72px; height: 72px; border-radius: 20px; font-size: 2.2rem;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-chip {
        display: inline-flex; align-items: center;
        padding: .3rem .8rem; border-radius: 50rem;
        background: #fff; border: 1px solid #e3e6f0;
        font-size: .8rem; font-weight: 600; color: #5a5c69;
    }
    .item-row { transition: background .15s, transform .15s; border-radius: 12px; }
    .item-row:hover { background: #f8f9fc; transform: translateX(3px); }
    .order-badge {
        width: 34px; height: 34px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }
    .icon-btn {
        width: 34px; height: 34px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 10px; border: 0; transition: all .15s;
    }
    .icon-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.15); text-decoration: none; }
    .icon-btn.edit   { background: #e8f0fe; color: #4e73df; }
    .icon-btn.edit:hover   { background: #4e73df; color: #fff; }
    .icon-btn.delete { background: #fdecea; color: #e74a3b; }
    .icon-btn.delete:hover { background: #e74a3b; color: #fff; }
</style>

<div class="container py-4" style="max-width: 920px;">

    {{-- Top bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: .5rem;">
        <a href="{{ route('topics.index') }}" class="small font-weight-bold text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Topics
        </a>
        <a href="{{ route('topics.edit', $topic) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            <i class="fas fa-pen mr-1"></i> Edit Topic
        </a>
    </div>

    {{-- Hero card --}}
    <div class="card shadow border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4"
             style="background: {{ $color }}12; border-left: 6px solid {{ $color }};">
            <div class="d-flex align-items-center" style="gap: 1.25rem;">
                <div class="hero-tile" style="background: {{ $color }}25;">
                    {{ $subject->emoji ?? '📘' }}
                </div>

                <div class="flex-grow-1">
                    <div class="small text-uppercase font-weight-bold mb-1" style="color: {{ $color }};">
                        <i class="fas fa-book-open mr-1"></i>{{ $subject->name ?? 'No Subject' }}
                    </div>
                    <h1 class="h3 font-weight-bold text-gray-800 mb-2">{{ $topic->name }}</h1>
                    <div class="d-flex flex-wrap" style="gap: .5rem;">
                        <span class="stat-chip">
                            <i class="fas fa-list-ul mr-1" style="color: {{ $color }};"></i>
                            {{ $topic->items->count() }} {{ \Illuminate\Support\Str::plural('item', $topic->items->count()) }}
                        </span>
                        <span class="stat-chip">
                            <i class="fas fa-sort-numeric-down mr-1" style="color: {{ $color }};"></i>
                            Order {{ $topic->sort_order ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            @if($topic->detail)
                <hr class="my-3">
                <p class="text-gray-700 mb-0">
                    <i class="fas fa-align-left mr-2 text-muted"></i>{{ $topic->detail }}
                </p>
            @endif
        </div>
    </div>

    {{-- Items card --}}
    <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 font-weight-bold text-gray-800 mb-0">
                    <i class="fas fa-list-ul mr-2" style="color: {{ $color }};"></i>
                    Items
                    <span class="badge badge-pill text-white ml-1" style="background: {{ $color }};">
                        {{ $topic->items->count() }}
                    </span>
                </h2>
                <a href="{{ route('items.create', ['topic_id' => $topic->id]) }}"
                   class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Add Item
                </a>
            </div>

            @forelse($items as $item)
                <div class="item-row d-flex justify-content-between align-items-center p-2 mb-1">
                    <div class="d-flex align-items-center" style="gap: .75rem;">
                        <span class="order-badge"
                              style="background: {{ $color }}22; color: {{ $color }};">
                            {{ $item->sort_order }}
                        </span>
                        <span class="font-weight-bold text-gray-800">{{ $item->heading }}</span>
                    </div>

                    <div class="d-inline-flex" style="gap: .4rem;">
                        <a href="{{ route('items.edit', $item) }}" class="icon-btn edit" title="Edit item">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST"
                              onsubmit="return confirm('Delete item?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="icon-btn delete" title="Delete item">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div style="font-size: 3rem;">🗂️</div>
                    <p class="text-muted mt-2 mb-3">No items in this topic yet.</p>
                    <a href="{{ route('items.create', ['topic_id' => $topic->id]) }}"
                       class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-plus mr-1"></i> Add the first item
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection