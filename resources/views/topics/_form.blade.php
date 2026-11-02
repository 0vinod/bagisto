@php $t = $topic ?? null; @endphp

<div>
    <label class="block text-sm font-medium mb-1">Subject</label>
    <select name="subject_id" class="w-full border rounded p-2" required>
        <option value="">-- Select --</option>
        @foreach($subjects as $s)
            <option value="{{ $s->id }}" @selected(old('subject_id', $t->subject_id ?? '') == $s->id)>
                {{ $s->emoji }} {{ $s->name }}
            </option>
        @endforeach
    </select>
    @error('subject_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Topic Name</label>
    <input type="text" name="name" value="{{ old('name', $t->name ?? '') }}"
           class="w-full border rounded p-2" required>
    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Detail</label>
    <textarea name="detail" rows="3" class="w-full border rounded p-2">{{ old('detail', $t->detail ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Sort Order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $t->sort_order ?? 0) }}"
           class="w-full border rounded p-2">
</div>
