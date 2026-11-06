@php $it = $item ?? null; @endphp

<div class="mb-3">
    <label class="form-label fw-medium">Topic</label>
    <select name="topic_id" class="form-select" required>
        <option value="">-- Select --</option>
        @foreach($topics as $t)
            <option value="{{ $t->id }}"
                @selected(old('topic_id', $selectedTopic ?? $it->topic_id ?? '') == $t->id)>
                {{ $t->subject->name ?? '' }} → {{ $t->name }}
            </option>
        @endforeach
    </select>
    @error('topic_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-medium">Heading</label>
    <input type="text" name="heading" value="{{ old('heading', $it->heading ?? '') }}"
           class="form-control" required>
    @error('heading') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-medium">Sort Order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $it->sort_order ?? 0) }}"
           class="form-control">
</div>
