{{-- Admin & Owner Kamar Form - Shared Template --}}
<div class="form-group">
    <label for="name">Nama Kamar *</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
        value="{{ old('name', $homestay->name ?? '') }}" required>
    <small class="form-text">Nama akan tampil pada daftar kamar</small>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="slug">Slug (opsional)</label>
    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" 
        value="{{ old('slug', $homestay->slug ?? '') }}" placeholder="Contoh: kamar-manikam-1">
    <small class="form-text">Jika dikosongkan, sistem akan membuat slug otomatis dari nama.</small>
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="categories">Kategori * (pilih lebih dari satu)</label>
        <select id="categories" name="categories[]" class="form-control @error('categories') is-invalid @enderror" multiple required>
            @php 
                $selected = old('categories', isset($homestay) && $homestay->categories ? $homestay->categories->pluck('id')->toArray() : []);
            @endphp
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ in_array($cat->id, (array) $selected) ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <small class="form-text">Gunakan Ctrl/Cmd atau Shift untuk memilih beberapa kategori.</small>
        @error('categories')<div class="invalid-feedback">{{ $message }}</div>@enderror

        <div class="form-text mt-2">Atau ketik kategori baru:</div>
        <input list="category-list" name="category_name" id="category_name" class="form-control mt-1"
            placeholder="Contoh: Kost" value="{{ old('category_name', '') }}">
        <datalist id="category-list">
            @foreach($categories as $cat)
                <option value="{{ $cat->name }}"></option>
            @endforeach
        </datalist>
    </div>

    <div class="form-group">
        <label for="location_id">Lokasi/Alamat *</label>
        <select id="location_id" name="location_id" class="form-control @error('location_id') is-invalid @enderror" required>
            <option value="">-- Pilih Lokasi --</option>
            @foreach($locations as $loc)
                <option value="{{ $loc->id }}" {{ (old('location_id', $homestay->location_id ?? '') == $loc->id) ? 'selected' : '' }}>
                    {{ $loc->name }}
                </option>
            @endforeach
        </select>
        @error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="address">Alamat Lengkap</label>
    <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" 
        value="{{ old('address', $homestay->location ?? '') }}" placeholder="Masukkan alamat lengkap yang akan tampil di listing">
    <small class="form-text">Contoh: Jalan, RT/RW, Desa/Kelurahan (opsional)</small>
    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi *</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
        rows="5" required>{{ old('description', $homestay->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="max_guests">Kapasitas Maksimal Tamu *</label>
        <input type="number" id="max_guests" name="max_guests" class="form-control @error('max_guests') is-invalid @enderror" 
            value="{{ old('max_guests', $homestay->max_guests ?? 1) }}" min="1" required>
        @error('max_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="price_per_night">Harga per Malam (Rp)</label>
        <input type="number" id="price_per_night" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" 
            value="{{ old('price_per_night', $homestay->price_per_night ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — harga per malam</small>
        @error('price_per_night')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="price_per_month">Harga per Bulan (Rp)</label>
        <input type="number" id="price_per_month" name="price_per_month" class="form-control @error('price_per_month') is-invalid @enderror" 
            value="{{ old('price_per_month', $homestay->price_per_month ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk kost/jangka panjang</small>
        @error('price_per_month')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="price_per_year">Harga per Tahun (Rp)</label>
        <input type="number" id="price_per_year" name="price_per_year" class="form-control @error('price_per_year') is-invalid @enderror" 
            value="{{ old('price_per_year', $homestay->price_per_year ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk sewa tahunan</small>
        @error('price_per_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="bedrooms">Jumlah Kamar Tidur *</label>
        <input type="number" id="bedrooms" name="bedrooms" class="form-control @error('bedrooms') is-invalid @enderror" 
            value="{{ old('bedrooms', $homestay->bedrooms ?? 1) }}" min="1" required>
        @error('bedrooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="bathrooms">Jumlah Kamar Mandi *</label>
        <input type="number" id="bathrooms" name="bathrooms" class="form-control @error('bathrooms') is-invalid @enderror" 
            value="{{ old('bathrooms', $homestay->bathrooms ?? 1) }}" min="1" required>
        @error('bathrooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
    <textarea id="amenities" name="amenities" class="form-control @error('amenities') is-invalid @enderror" 
        rows="3" placeholder="Contoh: WiFi, AC, Dapur, Kolam Renang...">{{ old('amenities', isset($homestay->amenities) ? implode(',', (array) $homestay->amenities) : '') }}</textarea>
    @error('amenities')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="image_url">Foto Utama (Cover)</label>
    @if(!empty($homestay->image_url ?? null))
        <div class="current-image mb-3">
            <a href="{{ asset('storage/' . $homestay->image_url) }}" target="_blank" rel="noopener">
                <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}" class="image-preview">
            </a>
            <p class="text-muted small mt-2">Foto saat ini</p>
        </div>
    @endif
    <input type="file" id="image_url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" accept="image/*">
    <small class="form-text">Format: JPG, PNG, GIF. Max 2MB. {{ !empty($homestay->image_url ?? null) ? '(Kosongkan jika tidak ingin mengubah)' : '(Opsional)' }}</small>
    @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="images">Gambar Tambahan (galeri)</label>
    <input type="file" id="images" name="images[]" class="form-control @error('images.*') is-invalid @enderror" accept="image/*" multiple>
    <small class="form-text">Unggah beberapa gambar untuk galeri (opsional). Format: JPG, PNG, WEBP. Max 4MB per file.</small>
    @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

@if(!empty($homestay->images ?? null) && is_array($homestay->images) && count($homestay->images))
    <div class="form-group">
        <label class="form-label">Gambar Galeri yang Sudah Ada</label>
        <div class="d-flex gap-2 flex-wrap">
            @foreach($homestay->images as $img)
                <div style="width: 120px; text-align: center;">
                    @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                        <img src="{{ asset('storage/' . $img) }}" alt="" class="image-preview-small">
                    @else
                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="" class="image-preview-small">
                    @endif
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="remove_images[]" value="{{ $img }}" id="remove_{{ md5($img) }}">
                        <label class="form-check-label small" for="remove_{{ md5($img) }}">Hapus</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if(\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured'))
    <div class="form-group form-check mt-3">
        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" 
            {{ old('is_featured', $homestay->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">Tandai sebagai <strong>Kamar Pilihan</strong></label>
    </div>
@endif

<div class="form-group text-muted small">
    <em>Gambar tambahan dapat diunggah saat edit atau melalui galeri homestay.</em>
</div>
