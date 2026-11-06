@csrf

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Subject Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $subject->name ?? '') }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Mathematics">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Emoji</label>
            <input type="text" name="emoji" value="{{ old('emoji', $subject->emoji ?? '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. ➗">
            <p class="text-xs text-gray-500 mt-1">Pick an emoji like 📘, 🔤, 📖</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Theme Color</label>
            <div class="flex items-center space-x-2">
                <input type="color" name="color" value="{{ old('color', $subject->color ?? '#6366f1') }}" class="h-10 w-14 border border-gray-300 rounded cursor-pointer">
                <span class="text-sm text-gray-500">Click to pick</span>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Short Note</label>
        <textarea name="short_note" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Number system, fractions, geometry">{{ old('short_note', $subject->short_note ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $subject->sort_order ?? 0) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <p class="text-xs text-gray-500 mt-1">Smaller numbers appear first.</p>
    </div>
</div>