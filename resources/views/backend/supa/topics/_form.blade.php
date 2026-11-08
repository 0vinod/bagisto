@php $t = $topic ?? null; @endphp

<style>
    .form-control:focus { box-shadow: 0 0 0 .2rem rgba(78,115,223,.15); }
    .input-group-text { background: #f8f9fc; color: #4e73df; }

    .subject-chip { position: relative; margin: 0; cursor: pointer; }
    .subject-chip input {
        position: absolute; opacity: 0; width: 1px; height: 1px;
    }
    .subject-chip .chip-body {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .45rem .9rem; border-radius: 50rem;
        border: 2px solid #e3e6f0; background: #fff;
        font-weight: 600; font-size: .85rem; color: #5a5c69;
        transition: all .15s;
    }
    .subject-chip:hover .chip-body { transform: translateY(-2px); border-color: var(--c); }
    .subject-chip input:checked + .chip-body {
        background: var(--c); border-color: var(--c); color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,.15);
    }
    .subject-chip input:focus + .chip-body { box-shadow: 0 0 0 .2rem rgba(78,115,223,.25); }

    .pv-tile {
        width: 56px; height: 56px; border-radius: 16px; font-size: 1.8rem;
        display: inline-flex; align-items: center; justify-content: center;
    }
</style>

<div class="row">

    {{-- LEFT: fields --}}
    <div class="col-lg-7">

        {{-- Subject chips --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-book-open mr-1"></i> Subject <span class="text-danger">*</span>
            </label>
            <div class="d-flex flex-wrap" style="gap: .5rem;">
                @foreach($subjects as $s)
                    @php $c = $s->color ?? '#6366f1'; @endphp
                    <label class="subject-chip" style="--c: {{ $c }};">
                        <input type="radio" name="subject_id" value="{{ $s->id }}" required
                               data-name="{{ $s->name }}"
                               data-emoji="{{ $s->emoji ?: '📘' }}"
                               data-color="{{ $c }}"
                               @checked(old('subject_id', $t->subject_id ?? request('subject_id')) == $s->id)>
                        <span class="chip-body">{{ $s->emoji ?: '📘' }} {{ $s->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('subject_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
        </div>

        {{-- Name --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-bookmark mr-1"></i> Topic Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="f-name" required
                   value="{{ old('name', $t->name ?? '') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="e.g. Fractions">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Detail --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-align-left mr-1"></i> Detail
            </label>
            <textarea name="detail" id="f-detail" rows="3"
                      class="form-control @error('detail') is-invalid @enderror"
                      placeholder="What does this topic cover?">{{ old('detail', $t->detail ?? '') }}</textarea>
            @error('detail') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Sort order --}}
        <div class="form-group mb-0">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-sort-numeric-down mr-1"></i> Sort Order
            </label>
            <div class="input-group" style="max-width: 200px;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                </div>
                <input type="number" name="sort_order" id="f-order"
                       value="{{ old('sort_order', $t->sort_order ?? 0) }}"
                       class="form-control @error('sort_order') is-invalid @enderror">
            </div>
            <small class="text-muted">Smaller numbers appear first.</small>
        </div>
    </div>

    {{-- RIGHT: live preview --}}
    <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="small text-uppercase text-muted font-weight-bold mb-2">
            <i class="fas fa-eye mr-1"></i> Live Preview
        </div>

        <div id="pv-card" class="p-4"
             style="border-radius: 16px; background: #f8f9fc; border-left: 5px solid #6366f1;">
            <div class="d-flex align-items-center mb-3">
                <div id="pv-tile" class="pv-tile mr-3">📘</div>
                <div class="font-weight-bold text-gray-800" id="pv-subject">Choose a subject</div>
            </div>
            <h5 id="pv-name" class="font-weight-bold text-gray-800 mb-2">Topic name</h5>
            <p id="pv-detail" class="text-muted small mb-3">Topic details appear here.</p>
            <span class="text-muted small">
                <i class="fas fa-sort-numeric-down mr-1"></i>Order: <span id="pv-order">0</span>
            </span>
        </div>
    </div>
</div>

<script>
(function () {
    var name   = document.getElementById('f-name');
    var detail = document.getElementById('f-detail');
    var order  = document.getElementById('f-order');
    var radios = document.querySelectorAll('input[name="subject_id"]');

    function render() {
        var sel = document.querySelector('input[name="subject_id"]:checked');
        var color = sel ? sel.dataset.color : '#6366f1';

        document.getElementById('pv-subject').textContent = sel ? sel.dataset.name : 'Choose a subject';
        document.getElementById('pv-name').textContent    = name.value || 'Topic name';
        document.getElementById('pv-detail').textContent  = detail.value || 'Topic details appear here.';
        document.getElementById('pv-order').textContent   = order.value || 0;

        var tile = document.getElementById('pv-tile');
        tile.textContent = sel ? sel.dataset.emoji : '📘';
        tile.style.background = color + '22';
        document.getElementById('pv-card').style.borderLeftColor = color;
    }

    [name, detail, order].forEach(function (el) { el.addEventListener('input', render); });
    radios.forEach(function (r) { r.addEventListener('change', render); });
    render();
})();
</script>