 
<style>
    .form-control:focus { box-shadow: 0 0 0 .2rem rgba(78,115,223,.15); }
    .bullet-row { display: flex; gap: .5rem; margin-bottom: .5rem; }
    .bullet-row .btn { flex-shrink: 0; }
    #img-preview { max-width: 100%; max-height: 220px; border-radius: 12px; margin-top: .5rem; display: none; }
</style>

 

<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-heading mr-1"></i> Heading <span class="text-danger">*</span>
    </label>
    <input type="text" name="heading" required value="{{ old('heading', $p->heading ?? '') }}"
           class="form-control @error('heading') is-invalid @enderror" placeholder="e.g. Piaget's Stages">
    @error('heading') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<style>
    .bullet-row { display: flex; gap: .5rem; margin-bottom: .5rem; }
    .bullet-row .btn { flex-shrink: 0; }
    .block-img { max-width: 100%; max-height: 180px; border-radius: 12px; margin-top: .5rem; display: none; }
</style>

@php
    // Saved JSON (edit) or the user's previous input (validation error)
    $raw = old('points', $p->points ?? []);
    if (is_string($raw)) { $raw = json_decode($raw, true) ?: []; }
@endphp

<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-layer-group mr-1"></i> Sections
    </label>

    <div id="blocks"></div>

    <button type="button" id="add-block" class="btn btn-sm btn-primary">
        <i class="fas fa-plus mr-1"></i> Add More
    </button>

    @error('points') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
    @error('points.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

{{-- One repeating block --}}
<template id="block-tpl">
    <div class="card mb-3 point-block">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <strong class="small text-uppercase text-muted block-title">Block</strong>
            <button type="button" class="btn btn-sm btn-outline-danger remove-block" title="Remove block">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="small text-muted">Sub Heading</label>
                <input type="text" class="form-control f-sub" placeholder="Optional">
            </div>

            <div class="form-group">
                <label class="small text-muted">Image</label>
                <input type="file" class="form-control f-image" accept="image/*">
                <input type="hidden" class="f-existing">
                <img class="block-img" alt="" onerror="this.style.display='none'">
                <small class="text-muted d-block mt-1 keep-note" style="display:none !important;">
                    Leave empty to keep the current image.
                </small>
            </div>

            <div class="form-group mb-0">
                <label class="small text-muted">Text</label>
                <div class="texts"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary add-text">
                    <i class="fas fa-plus mr-1"></i> Add more text
                </button>
            </div>
        </div>
    </div>
</template>

 
<div class="form-group mb-0">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-sort-numeric-down mr-1"></i> Sort Order
    </label>
    <div class="input-group" style="max-width: 200px;">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
        <input type="number" name="sort_order" value="{{ old('sort_order', $p->sort_order ?? ($nextOrder ?? 0)) }}" class="form-control">
    </div>
    <small class="text-muted">Smaller numbers appear first.</small>
</div>

<script>
(function () {
    const initial = @json($raw);
    const wrap = document.getElementById('blocks');
    const tpl  = document.getElementById('block-tpl');
    let idx = 0; // unique, only used to build field names

    function addText(block, value) {
        const i = block.dataset.index;
        const row = document.createElement('div');
        row.className = 'bullet-row';
        row.innerHTML =
            '<input type="text" class="form-control" placeholder="Enter text">' +
            '<button type="button" class="btn btn-outline-danger remove-text" title="Remove"><i class="fas fa-times"></i></button>';
        const input = row.querySelector('input');
        input.name  = 'points[' + i + '][texts][]';
        input.value = value || '';
        block.querySelector('.texts').appendChild(row);
    }

    function renumber() {
        wrap.querySelectorAll('.point-block').forEach(function (b, n) {
            b.querySelector('.block-title').textContent = 'Block ' + (n + 1);
        });
    }

    function addBlock(d) {
        d = d || {};
        const i = idx++;
        const block = tpl.content.firstElementChild.cloneNode(true);
        block.dataset.index = i;

        const sub = block.querySelector('.f-sub');
        sub.name  = 'points[' + i + '][sub_heading]';
        sub.value = d.sub_heading || '';

        const file = block.querySelector('.f-image');
        file.name = 'points[' + i + '][image]';

        const existing = block.querySelector('.f-existing');
        existing.name  = 'points[' + i + '][existing_image]';
        existing.value = d.existing_image || d.image_url || '';

        const img = block.querySelector('.block-img');
        if (existing.value) {
            img.src = existing.value;
            img.style.display = 'block';
            block.querySelector('.keep-note').style.cssText = 'display:block';
        }
        file.addEventListener('change', function () {
            if (file.files[0]) {
                img.src = URL.createObjectURL(file.files[0]);
                img.style.display = 'block';
            }
        });

        const texts = (d.texts && d.texts.length) ? d.texts : [''];
        texts.forEach(function (t) { addText(block, t); });

        wrap.appendChild(block);
        renumber();
    }

    // Event delegation for all buttons
    document.addEventListener('click', function (e) {
        const t = e.target.closest('button');
        if (!t) return;

        if (t.id === 'add-block') { addBlock(); return; }

        const block = t.closest('.point-block');
        if (!block) return;

        if (t.classList.contains('remove-block')) { block.remove(); renumber(); }
        else if (t.classList.contains('add-text'))  { addText(block, ''); }
        else if (t.classList.contains('remove-text')) { t.closest('.bullet-row').remove(); }
    });

    // Boot: existing data, or one empty block
    if (Array.isArray(initial) && initial.length) initial.forEach(addBlock);
    else addBlock();
})();
</script>
 
