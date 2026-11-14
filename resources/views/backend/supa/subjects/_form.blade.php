@csrf

<style>
    .emoji-pick {
        width: 40px; height: 40px; font-size: 1.3rem; line-height: 1;
        border: 1px solid #e3e6f0; background: #fff; border-radius: 12px;
        cursor: pointer; transition: all .15s;
    }
    .emoji-pick:hover { background: #eaecf4; transform: translateY(-2px); }
    .preview-tile {
        width: 64px; height: 64px; border-radius: 18px; font-size: 2rem;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .form-control:focus { box-shadow: 0 0 0 .2rem rgba(78,115,223,.15); }
    .input-group-text { background: #f8f9fc; color: #4e73df; }
</style>

<div class="row">

    {{-- LEFT: fields --}}
    <div class="col-lg-7">

        {{-- Name --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-tag mr-1"></i> Subject Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="f-name" required
                   value="{{ old('name', $subject->name ?? '') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="e.g. Mathematics">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Emoji --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="far fa-smile mr-1"></i> Emoji
            </label>
            <input type="text" name="emoji" id="f-emoji"
                   value="{{ old('emoji', $subject->emoji ?? '') }}"
                   class="form-control mb-2" placeholder="e.g. ➗" maxlength="8">
            <div class="d-flex flex-wrap" style="gap: .4rem;">
                @foreach(['📘','📖','🔤','➗','📐','🔬','🧪','🌍','🏛️','💻','🎨','⚖️','🧠','📊'] as $e)
                    <button type="button" class="emoji-pick" data-emoji="{{ $e }}">{{ $e }}</button>
                @endforeach
            </div>
            <small class="text-muted">Type your own or click one above.</small>
        </div>

        {{-- Color --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-palette mr-1"></i> Theme Color
            </label>
            <div class="d-flex align-items-center" style="gap: .75rem;">
                <input type="color" name="color" id="f-color"
                       value="{{ old('color', $subject->color ?? '#6366f1') }}"
                       style="width: 56px; height: 42px; border: 1px solid #d1d3e2; border-radius: 10px; padding: 3px; cursor: pointer;">
                <code id="f-color-hex" class="px-2 py-1 bg-light rounded">
                    {{ old('color', $subject->color ?? '#6366f1') }}
                </code>
            </div>
        </div>

        {{-- Short note --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-sticky-note mr-1"></i> Short Note
            </label>
            <textarea name="short_note" id="f-note" rows="2" class="form-control"
                      placeholder="e.g. Number system, fractions, geometry">{{ old('short_note', $subject->short_note ?? '') }}</textarea>
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
                <input type="number" name="sort_order"
                       value="{{ old('sort_order', $subject->sort_order ?? 0) }}"
                       class="form-control">
            </div>
            <small class="text-muted">Smaller numbers appear first.</small>
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
                <input type="text" name="weightage"
                       value="{{ old('weightage', $subject->weightage ?? 0) }}"
                       class="form-control">
            </div>
            
        </div>
    </div>

    {{-- RIGHT: live preview --}}
    <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="small text-uppercase text-muted font-weight-bold mb-2">
            <i class="fas fa-eye mr-1"></i> Live Preview
        </div>

        <div id="pv-card" class="p-4 text-center"
             style="border-radius: 16px; background: #f8f9fc; border-left: 5px solid #6366f1;">
            <div id="pv-tile" class="preview-tile mb-3">📘</div>
            <h5 id="pv-name" class="font-weight-bold text-gray-800 mb-1">Subject name</h5>
            <p id="pv-note" class="text-muted small mb-0">Your short note appears here.</p>
        </div>
    </div>
</div>

<script>
(function () {
    var name  = document.getElementById('f-name');
    var emoji = document.getElementById('f-emoji');
    var color = document.getElementById('f-color');
    var note  = document.getElementById('f-note');
    var hex   = document.getElementById('f-color-hex');

    function render() {
        var c = color.value;
        document.getElementById('pv-name').textContent = name.value || 'Subject name';
        document.getElementById('pv-note').textContent = note.value || 'Your short note appears here.';
        var tile = document.getElementById('pv-tile');
        tile.textContent = emoji.value || '📘';
        tile.style.background = c + '22';
        document.getElementById('pv-card').style.borderLeftColor = c;
        hex.textContent = c;
    }

    [name, emoji, color, note].forEach(function (el) {
        el.addEventListener('input', render);
    });

    document.querySelectorAll('.emoji-pick').forEach(function (btn) {
        btn.addEventListener('click', function () {
            emoji.value = btn.dataset.emoji;
            render();
        });
    });

    render();
})();
</script>