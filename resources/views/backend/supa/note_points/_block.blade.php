@php
    $b = is_array($b ?? null) ? $b : [];
    $texts = !empty($b['texts']) ? $b['texts'] : [''];
    $image = $b['existing_image'] ?? ($b['image_url'] ?? '');
@endphp

<div class="card mb-3 point-block" data-i="{{ $i }}">
    <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong class="small text-uppercase text-muted">Block</strong>

        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.point-block').remove()">
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <div class="card-body">

        {{-- Sub Heading --}}
        <div class="form-group">
            <label class="small text-muted">Sub Heading</label>
            <input type="text" name="points[{{ $i }}][sub_heading]" value="{{ $b['sub_heading'] ?? '' }}"
                class="form-control" placeholder="Optional">
        </div>

        {{-- Image --}}
        <div class="form-group">
            <label class="small text-muted">Image</label>

            <input type="file" name="points[{{ $i }}][image]" accept="image/*" class="form-control">

            <input type="hidden" name="points[{{ $i }}][existing_image]" value="{{ $image }}">

            @if ($image)
                <img src="{{ $image }}" alt=""
                    style="max-height:120px; border-radius:10px; margin-top:.5rem;" onerror="this.remove()">

                <small class="text-muted d-block mt-1">
                    Leave empty to keep the current image.
                </small>
            @endif
        </div>

        {{-- Rich Text --}}
        <div class="form-group mb-0">
            <label class="small text-muted">Text</label>

            <div class="rich-text-list">

                @foreach ($texts as $t)
                    <div class="rich-text-row mb-3">

                        <div class="ql-toolbar rich-toolbar">
                            <span class="ql-formats">
                                <button type="button" class="ql-bold"></button>
                                <button type="button" class="ql-italic"></button>
                                <button type="button" class="ql-underline"></button>
                                <button type="button" class="ql-strike"></button>
                            </span>

                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>

                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                            </span>

                            <span class="ql-formats">
                                <select class="ql-align"></select>
                            </span>

                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-clean"></button>
                            </span>

                            <button type="button" class="btn btn-sm btn-outline-danger remove-rich-text ml-2"
                                onclick="removeRichText(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <div class="quill-editor"></div>

                        <input type="hidden" name="points[{{ $i }}][texts][]" class="rich-text-value"
                            value="{{ $t }}">
                    </div>
                @endforeach

            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addText(this)">
                <i class="fas fa-plus mr-1"></i> Add more text
            </button>
        </div>

    </div>
</div>
