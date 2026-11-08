@php
    $it = $item ?? null;
    $grouped = $topics->groupBy(fn($t) => $t->subject->name ?? 'No Subject');
@endphp

<style>
    .form-control:focus, .custom-select:focus { box-shadow: 0 0 0 .2rem rgba(78,115,223,.15); }
    .input-group-text { background: #f8f9fc; color: #4e73df; }
    .pv-tile {
        width: 56px; height: 56px; border-radius: 16px; font-size: 1.8rem;
        display: inline-flex; align-items: center; justify-content: center;
    }
</style>

<div class="row">

    {{-- LEFT: fields --}}
    <div class="col-lg-7">

        {{-- Topic --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-folder-open mr-1"></i> Topic <span class="text-danger">*</span>
            </label>
            <select name="topic_id" id="f-topic" required
                    class="custom-select @error('topic_id') is-invalid @enderror">
                <option value="">-- Select a topic --</option>
                @foreach($grouped as $subjectName => $subjectTopics)
                    @php $s = $subjectTopics->first()->subject ?? null; @endphp
                    <optgroup label="{{ $s->emoji ?? '📘' }} {{ $subjectName }}">
                        @foreach($subjectTopics as $t)
                            <option value="{{ $t->id }}"
                                    data-subject="{{ $subjectName }}"
                                    data-emoji="{{ $s->emoji ?? '📘' }}"
                                    data-color="{{ $s->color ?? '#6366f1' }}"
                                    @selected(old('topic_id', $selectedTopic ?? $it->topic_id ?? '') == $t->id)>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('topic_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Heading --}}
        <div class="form-group">
            <label class="font-weight-bold small text-uppercase text-muted">
                <i class="fas fa-heading mr-1"></i> Heading <span class="text-danger">*</span>
            </label>
            <input type="text" name="heading" id="f-heading" required
                   value="{{ old('heading', $it->heading ?? '') }}"
                   class="form-control @error('heading') is-invalid @enderror"
                   placeholder="e.g. Types of fractions">
            @error('heading') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                       value="{{ old('sort_order', $it->sort_order ?? 0) }}"
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
                <div>
                    <div id="pv-subject" class="font-weight-bold text-gray-800">Subject</div>
                    <span class="badge badge-light border mt-1">
                        <i class="fas fa-folder mr-1"></i><span id="pv-topic">Topic</span>
                    </span>
                </div>
            </div>
            <h5 id="pv-heading" class="font-weight-bold text-gray-800 mb-2">Item heading</h5>
            <span class="text-muted small">
                <i class="fas fa-sort-numeric-down mr-1"></i>Order: <span id="pv-order">0</span>
            </span>
        </div>
    </div>
</div>

<script>
(function () {
    var topic   = document.getElementById('f-topic');
    var heading = document.getElementById('f-heading');
    var order   = document.getElementById('f-order');

    function render() {
        var opt   = topic.options[topic.selectedIndex];
        var color = (opt && opt.dataset.color) || '#6366f1';

        document.getElementById('pv-subject').textContent = (opt && opt.dataset.subject) || 'Subject';
        document.getElementById('pv-topic').textContent   = (opt && opt.value) ? opt.text.trim() : 'Topic';
        document.getElementById('pv-heading').textContent = heading.value || 'Item heading';
        document.getElementById('pv-order').textContent   = order.value || 0;

        var tile = document.getElementById('pv-tile');
        tile.textContent = (opt && opt.dataset.emoji) || '📘';
        tile.style.background = color + '22';
        document.getElementById('pv-card').style.borderLeftColor = color;
    }

    [topic, heading, order].forEach(function (el) {
        el.addEventListener('input', render);
        el.addEventListener('change', render);
    });
    render();
})();
</script>