@php $t = $topic ?? null; @endphp

<div class="mb-3">
    <label class="form-label fw-medium">Subject</label>
    <select name="subject_id" class="form-select" required>
        <option value="">-- Select --</option>
        @foreach($subjects as $s)
            <option value="{{ $s->id }}" @selected(old('subject_id', $t->subject_id ?? '') == $s->id)>
                {{ $s->emoji }} {{ $s->name }}
            </option>
        @endforeach
    </select>
    @error('subject_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-medium">Topic Name</label>
    <input type="text" name="name" value="{{ old('name', $t->name ?? '') }}"
           class="form-control" required>
    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-medium">Detail</label>
    <textarea name="detail" rows="3" class="form-control">{{ old('detail', $t->detail ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-medium">Sort Order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $t->sort_order ?? 0) }}"
           class="form-control">
</div>
