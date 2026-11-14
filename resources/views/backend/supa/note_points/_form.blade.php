@php
    $p = $point ?? null;
    $bullets = old('points', $p->points ?? []);
    if (!is_array($bullets) || !count($bullets)) $bullets = [''];
@endphp

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

<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-text-height mr-1"></i> Sub Heading
    </label>
    <input type="text" name="sub_headings" value="{{ old('sub_headings', $p->sub_headings ?? '') }}"
           class="form-control @error('sub_headings') is-invalid @enderror" placeholder="Optional">
    @error('sub_headings') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-image mr-1"></i> Image
    </label>
    <input class="form-control @error('image_url') is-invalid @enderror"
           type="file" name="image_url" id="f-image" accept="image/*">
    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror

    <img id="img-preview" alt=""
         src="{{ $p->image_url ?? '' }}"
         style="max-width:100%; max-height:220px; border-radius:12px; margin-top:.5rem; {{ !empty($p->image_url) ? '' : 'display:none;' }}"
         onerror="this.style.display='none'">

    @if(!empty($p->image_url))
        <small class="text-muted d-block mt-1">Leave empty to keep the current image.</small>
    @endif
</div>

@php
    $clean = array_values(array_filter((array) $bullets, fn($b) => trim((string) $b) !== ''));
    if (count($clean) === 1 && preg_match('/<[a-z][\s\S]*>/i', $clean[0])) {
        $pointsHtml = $clean[0];                       // already saved as rich HTML
    } elseif (count($clean)) {
        $pointsHtml = '<ul>' . collect($clean)->map(fn($b) => '<li>' . e($b) . '</li>')->implode('') . '</ul>'; // old plain points
    } else {
        $pointsHtml = '';
    }
@endphp

<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-list-ul mr-1"></i> Points
    </label>
    <div id="points-editor" style="min-height:200px; background:#fff;"></div>
    <small class="text-muted d-block mt-1">Paste your text here. Formatting such as bold, lists, headings and links is kept.</small>
    <div id="points-hidden"></div>
    @error('points') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>


<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>


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
    // ---- rich text points ----
    var quill = new Quill('#points-editor', {
        theme: 'snow',
        placeholder: 'Paste or type your points here...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
                ['link', 'blockquote', 'clean']
            ]
        }
    });

    var initialHtml = @json($pointsHtml);
    if (initialHtml) quill.clipboard.dangerouslyPasteHTML(initialHtml);

    var hidden = document.getElementById('points-hidden');
    var form = document.getElementById('points-editor').closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            hidden.innerHTML = '';
            if (quill.getText().trim().length) {
                var h = document.createElement('input');
                h.type = 'hidden'; h.name = 'points[]'; h.value = quill.root.innerHTML;
                hidden.appendChild(h);
            }
        });
    }

    // ---- image preview ----
    var img = document.getElementById('f-image'), pv = document.getElementById('img-preview');
    img.addEventListener('change', function () {
        if (!img.files.length) return;
        pv.src = URL.createObjectURL(img.files[0]);
        pv.style.display = 'block';
    });
})();
</script>
