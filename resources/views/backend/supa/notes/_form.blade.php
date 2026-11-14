@php
    $n = $note ?? null;
    $subject = $subject ?? $n->subject;
    $color = $subject->color ?? '#6366f1';
    $emoji = $subject->emoji ?: '📒';
@endphp

<style>
    .form-control:focus { box-shadow: 0 0 0 .2rem rgba(78,115,223,.15); }
    .pv-img { width: 100%; height: auto; display: block; border-radius: 12px 12px 0 0; }
    .pv-ph { height: 110px; display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 12px 12px 0 0; }
    .pv-icon { width: 36px; height: 36px; object-fit: contain; border-radius: 8px; }
</style>

<div class="row">
    <div class="col-lg-7">

        {{-- Subject is fixed by the URL --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-book-open mr-1"></i> Subject
            </label>
            <div>
                <span class="badge badge-pill text-white px-3 py-2" style="background: {{ $color }}; font-size: .85rem;">
                    {{ $emoji }} {{ $subject->name }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-heading mr-1"></i> Title <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="f-title" required value="{{ old('title', $n->title ?? '') }}"
                   class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Child Development">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

       <div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-image mr-1"></i> Cover Image
    </label>
    <input type="file" name="image_url" id="f-image" accept="image/*"
           class="form-control @error('image_url') is-invalid @enderror">
    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if(!empty($n->image_url))
        <small class="text-muted d-block mt-1">Leave empty to keep the current image.</small>
    @endif
</div>

<div class="form-group">
    <label class="font-weight-bold small text-uppercase text-muted">
        <i class="fas fa-icons mr-1"></i> Icon
    </label>
    <input type="file" name="icon_url" id="f-icon" accept="image/*"
           class="form-control @error('icon_url') is-invalid @enderror">
    @error('icon_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
  
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-align-left mr-1"></i> Short Notes
            </label>
            <textarea name="short_notes" id="f-short" rows="3" class="form-control"
                      placeholder="One or two lines summary">{{ old('short_notes', $n->short_notes ?? '') }}</textarea>
        </div>
        
                        {{-- weightage --}}
        <div class="form-group mb-0">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-sort-numeric-down mr-1"></i>Weightage
            </label>
            <div class="input-group" style="max-width: 200px;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                </div>
                <input type="text" name="weightage" value="{{ old('weightage', $n->weightage ?? 0) }}" class="form-control">
            </div>
            
        </div>

        <div class="form-group mb-0">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-sort-numeric-down mr-1"></i> Sort Order
            </label>
            <div class="input-group" style="max-width: 200px;">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
                <input type="number" name="sort_order" value="{{ old('sort_order', $n->sort_order ?? 0) }}" class="form-control">
            </div>
            <small class="text-muted">Smaller numbers appear first.</small>
        </div>
    </div>

    <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="small text-uppercase text-muted font-weight-bold mb-2"><i class="fas fa-eye mr-1"></i> Live Preview</div>
        <div id="pv-card" style="border-radius: 16px; background: #f8f9fc; border-left: 5px solid {{ $color }}; overflow: hidden;">
            <div id="pv-cover"></div>
            <div class="p-3">
                <div class="d-flex align-items-center" style="gap: .6rem;">
                    <span id="pv-icon"></span>
                    <h5 id="pv-title" class="font-weight-bold text-gray-800 mb-0">Note title</h5>
                </div>
                <p id="pv-short" class="text-muted small mt-2 mb-0">Short notes appear here.</p>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var color = @json($color), emoji = @json($emoji);
    var title = document.getElementById('f-title'), image = document.getElementById('f-image'),
        icon = document.getElementById('f-icon'), short = document.getElementById('f-short');

    function render() {
        document.getElementById('pv-title').textContent = title.value || 'Note title';
        document.getElementById('pv-short').textContent = short.value || 'Short notes appear here.';

        var cover = document.getElementById('pv-cover');
        cover.innerHTML = '';
        function placeholder() {
            cover.innerHTML = '';
            var d = document.createElement('div');
            d.className = 'pv-ph'; d.style.background = color + '22'; d.textContent = emoji;
            cover.appendChild(d);
        }
        if (image.value.trim()) {
            var img = document.createElement('img');
            img.className = 'pv-img'; img.src = image.value.trim();
            img.onerror = placeholder;
            cover.appendChild(img);
        } else { placeholder(); }

        var ic = document.getElementById('pv-icon');
        ic.innerHTML = '';
        if (icon.value.trim()) {
            var i = document.createElement('img');
            i.className = 'pv-icon'; i.src = icon.value.trim();
            i.onerror = function () { ic.innerHTML = ''; };
            ic.appendChild(i);
        }
    }

    [title, image, icon, short].forEach(function (el) { el.addEventListener('input', render); });
    render();
})();
</script>