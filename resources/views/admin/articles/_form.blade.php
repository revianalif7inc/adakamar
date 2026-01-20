@csrf
<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}"
        class="form-control @error('title') is-invalid @enderror">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar (opsional)</label>
    @if(isset($article) && $article->image)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $article->image) }}" alt="cover" class="image-preview-small">
        </div>
    @endif
    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan (excerpt)</label>
    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
        rows="3">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
    @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Konten</label>
    <textarea name="body" class="form-control @error('body') is-invalid @enderror"
        rows="10">{{ old('body', $article->body ?? '') }}</textarea>
    @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

@if(isset($categories) && $categories->count())
    <div class="mb-3">
        <label class="form-label">Kategori (opsional)</label>
        <select name="categories[]" class="form-select" multiple size="6">
            @foreach($categories as $cat)
                @php $selected = in_array($cat->id, old('categories', isset($article) ? $article->categories->pluck('id')->toArray() : [])); @endphp
                <option value="{{ $cat->id }}" {{ $selected ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <div class="form-text">Tekan Ctrl/Cmd untuk memilih beberapa kategori.</div>
        <div class="form-text mt-2">Atau tambahkan kategori baru dengan mengetik nama pada kolom di bawah, pisahkan beberapa
            kategori dengan koma.</div>
        <input list="category-list" name="category_names" id="category_names" class="form-control mt-2"
            placeholder="Contoh: Tips, Panduan, Bali" value="{{ old('category_names', '') }}">
        <datalist id="category-list">
            @foreach($categories as $cat)
                <option value="{{ $cat->name }}"></option>
            @endforeach
        </datalist>
    </div>
@else
    <div class="mb-3">
        <label class="form-label">Kategori (opsional)</label>
        <div class="form-text text-muted">Belum ada kategori artikel. Ketik nama kategori di bawah untuk membuat baru.</div>
        <input list="category-list" name="category_names" id="category_names" class="form-control mt-2"
            placeholder="Contoh: Tips, Panduan, Bali" value="{{ old('category_names', '') }}">
        <datalist id="category-list"></datalist>
    </div>
@endif

<div class="mb-3"> <label class="form-label">Tanggal Publikasi (opsional)</label>
    <input type="datetime-local" name="published_at"
        value="{{ old('published_at', isset($article) && $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('Y-m-d\TH:i') : '') }}"
        class="form-control @error('published_at') is-invalid @enderror">
    @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>