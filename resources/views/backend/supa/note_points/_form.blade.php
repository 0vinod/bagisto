{{-- D:\quic\test\bagisto\test\bagisto\resources\views\backend\supa\note_points\_form.blade.php --}}
<style>
    .form-control:focus {
        box-shadow: 0 0 0 .2rem rgba(78, 115, 223, .15);
    }

    .bullet-row {
        display: flex;
        gap: .5rem;
        margin-bottom: .5rem;
    }

    .bullet-row .btn {
        flex-shrink: 0;
    }
</style>

@php
    // The point being edited ($p or $point), null on create
    $src = $p ?? ($point ?? null);

    // Saved blocks (edit) or what the user typed before a validation error
    $blocks = old('points', $src->points ?? []);

    // If it is still a JSON string, turn it into an array
    for ($n = 0; $n < 2 && is_string($blocks); $n++) {
        $blocks = json_decode($blocks, true);
    }
    if (!is_array($blocks)) {
        $blocks = [];
    }

    // Old data = plain list of strings -> show it as one block
    if ($blocks && is_string(reset($blocks))) {
        $blocks = [['texts' => $blocks]];
    }

    // Create page = start with one empty block
    if (!$blocks) {
        $blocks = [[]];
    }

    // Index for the next block added with the button
    $next = max(array_keys($blocks)) + 1;
@endphp

{{-- Heading --}}
<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-heading mr-1"></i> Heading
    </label>
    <input type="text" name="heading" required value="{{ old('heading', $src->heading ?? '') }}"
        class="form-control @error('heading') is-invalid @enderror" placeholder="e.g. Piaget's Stages">
    @error('heading')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-image mr-1"></i> Image
    </label>
    <input class="form-control @error('image_url') is-invalid @enderror"
           type="file" name="image_url" id="f-image" accept="image/*">
    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <img id="img-preview" alt=""
         src="{{ $src->image_url ?? '' }}"
         style="max-width:100%; max-height:220px; border-radius:12px; margin-top:.5rem; {{ !empty($src->image_url) ? '' : 'display:none;' }}"
         onerror="this.style.display='none'">

    @if(!empty($src->image_url))
        <small class="text-muted d-block mt-1">Leave empty to keep the current image.</small>
    @endif
</div>
{{-- Blocks --}}
<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-layer-group mr-1"></i> Sections
    </label>

    <div id="blocks">
        @foreach ($blocks as $i => $b)
            @include('backend.supa.note_points._block', ['i' => $i, 'b' => $b])
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-primary" onclick="addBlock()">
        <i class="fas fa-plus mr-1"></i> Add More
    </button>
</div>

{{-- Empty block used by the "Add More" button (__I__ is replaced by a number) --}}
<template id="block-template">
    @include('backend.supa.note_points._block', ['i' => '__I__', 'b' => []])
</template>

{{-- Sort order --}}
<div class="form-group mb-0">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-sort-numeric-down mr-1"></i> Sort Order
    </label>
    <div class="input-group" style="max-width: 200px;">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
        <input type="number" name="sort_order" value="{{ old('sort_order', $src->sort_order ?? ($nextOrder ?? 0)) }}"
            class="form-control">
    </div>
    <small class="text-muted">Smaller numbers appear first.</small>
</div>

<script>
 



let nextIndex = {{ $next }};

// Toolbar configuration
const quillToolbar = [
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ list: 'ordered' }, { list: 'bullet' }],
    [{ align: [] }],
    ['link'],
    ['clean']
];

// Initialize a single editor row
function initRichTextRow(row) {
    if (row.dataset.quillInitialized === '1') return;

    const editorElement = row.querySelector('.quill-editor');
    const hiddenInput = row.querySelector('.rich-text-value');
    const toolbar = row.querySelector('.rich-toolbar');

    if (!editorElement || !hiddenInput || !toolbar) return;

    const quill = new Quill(editorElement, {
        theme: 'snow',
        modules: {
            toolbar: toolbar
        },
        placeholder: 'Paste or type formatted content here...'
    });

    // Load existing saved HTML safely through Quill clipboard conversion
    if (hiddenInput.value.trim()) {
        const delta = quill.clipboard.convert({
            html: hiddenInput.value,
            text: ''
        });

        quill.setContents(delta, 'silent');
    }

    // Save HTML into hidden input whenever content changes
    quill.on('text-change', function () {
        hiddenInput.value = quill.root.innerHTML;
    });

    // Sync immediately after initialization
    hiddenInput.value = quill.root.innerHTML;

    row.dataset.quillInitialized = '1';
    row._quill = quill;
}

document.getElementById('blocks').closest('form').addEventListener('submit', function () {

    document.querySelectorAll('.rich-text-row').forEach(function (row) {

        if (row._quill) {
            const html = row._quill.root.innerHTML;
            const hidden = row.querySelector('.rich-text-value');

            hidden.value = html === '<p><br></p>' ? '' : html;
        }

    });

});
// Initialize all existing editors
function initAllRichText() {
    document.querySelectorAll('.rich-text-row').forEach(function (row) {
        initRichTextRow(row);
    });
}

// Add a new rich text row
function addText(button) {
    const block = button.closest('.point-block');
    const i = block.dataset.i;
    const container = block.querySelector('.rich-text-list');

    const row = document.createElement('div');

    row.className = 'rich-text-row mb-3';

    row.innerHTML = `
        <div class="ql-toolbar rich-toolbar">
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
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

            <button type="button"
                    class="btn btn-sm btn-outline-danger remove-rich-text ml-2"
                    onclick="removeRichText(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>

        <div class="quill-editor"></div>

        <input type="hidden"
               name="points[${i}][texts][]"
               class="rich-text-value"
               value="">
    `;

    container.appendChild(row);

    initRichTextRow(row);
}

// Remove a text row
function removeRichText(button) {
    const row = button.closest('.rich-text-row');

    if (row && row._quill) {
        row._quill = null;
    }

    if (row) {
        row.remove();
    }
}

// Add a new block
function addBlock() {
    let html = document.getElementById('block-template').innerHTML;

    html = html.replace(/__I__/g, nextIndex++);

    const container = document.getElementById('blocks');

    container.insertAdjacentHTML('beforeend', html);

    // Initialize editors inside the new block
    const newBlock = container.lastElementChild;

    if (newBlock) {
        newBlock.querySelectorAll('.rich-text-row').forEach(function (row) {
            initRichTextRow(row);
        });
    }
}

// Initialize editors on page load
document.addEventListener('DOMContentLoaded', function () {
    initAllRichText();
});

</script>
