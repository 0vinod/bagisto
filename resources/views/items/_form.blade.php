@php $it = $item ?? null; @endphp

<div>
    <label class="block text-sm font-medium mb-1">Topic</label>
    <select name="topic_id" class="w-full border rounded p-2" required>
        <option value="">-- Select --</option>
        @foreach($topics as $t)
            <option value="{{ $t->id }}"
                @selected(old('topic_id', $selectedTopic ?? $it->topic_id ?? '') == $t->id)>
                {{ $t->subject->name ?? '' }} → {{ $t->name }}
            </option>
        @endforeach
    </select>
    @error('topic_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Heading</label>
    <input type="text" name="heading" value="{{ old('heading', $it->heading ?? '') }}"
           class="w-full border rounded p-2" required>
    @error('heading') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Sort Order</label>
    <input type="number" name="sort_order" value="{{ old('sort_order', $it->sort_order ?? 0) }}"
           class="w-full border rounded p-2">
</div>
