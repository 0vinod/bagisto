{{-- resources/views/backend/supa/note_points/_block.blade.php
     One block. Needs: $i (index) and $b (array of saved data, can be empty) --}}
@php
    $b = is_array($b ?? null) ? $b : [];
    $texts = !empty($b['texts']) ? $b['texts'] : [''];
    $image = $b['existing_image'] ?? $b['image_url'] ?? '';
@endphp

<div class="card mb-3 point-block" data-i="{{ $i }}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong class="small text-uppercase text-muted">Block</strong>
        <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('.point-block').remove()">
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <div class="card-body">

        {{-- Sub heading --}}
        <div class="form-group">
            <label class="small text-muted">Sub Heading</label>
            <input type="text" name="points[{{ $i }}][sub_heading]"
                   value="{{ $b['sub_heading'] ?? '' }}" class="form-control" placeholder="Optional">
        </div>

        {{-- Image --}}
        <div class="form-group">
            <label class="small text-muted">Image</label>
            <input type="file" name="points[{{ $i }}][image]" accept="image/*" class="form-control">
            <input type="hidden" name="points[{{ $i }}][existing_image]" value="{{ $image }}">

            @if($image)
                <img src="{{ $image }}" alt="" style="max-height:120px; border-radius:10px; margin-top:.5rem;"
                     onerror="this.remove()">
                <small class="text-muted d-block mt-1">Leave empty to keep the current image.</small>
            @endif
        </div>

        {{-- Texts (can add more) --}}
        <div class="form-group mb-0">
            <label class="small text-muted">Text</label>

            <div class="texts">
                @foreach($texts as $t)
                    <div class="bullet-row">
                        <input type="text" name="points[{{ $i }}][texts][]" value="{{ $t }}" class="form-control">
                        <button type="button" class="btn btn-outline-danger"
                                onclick="this.closest('.bullet-row').remove()">&times;</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addText(this)">
                <i class="fas fa-plus mr-1"></i> Add more text
            </button>
        </div>

    </div>
</div>