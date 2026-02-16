<div class="form-group">
    <label for="name">Nama Kamar *</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $homestay->name ?? '') }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="slug">Slug (opsional)</label>
    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
        value="{{ old('slug', $homestay->slug ?? '') }}" placeholder="Contoh: kamar-manikam-1">
    <small class="form-text">Kosongkan untuk auto-generate berdasarkan nama. Hanya huruf, angka dan dash (-) yang
        diperbolehkan.</small>
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="categories">Kategori *</label>
        <select id="categories" name="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @php $selected = old('category_id', isset($homestay) ? ($homestay->categories->first()->id ?? '') : ''); @endphp
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" {{ ($selected == $category->id) ? 'selected' : '' }}>{{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="location_id">Lokasi/Alamat *</label>
        <select id="location_id" name="location_id" class="form-control" required>
            <option value="">-- Pilih Lokasi --</option>
            @foreach(\App\Models\Location::all() as $location)
                <option value="{{ $location->id }}" {{ (old('location_id', $homestay->location_id ?? '') == $location->id) ? 'selected' : '' }}>{{ $location->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="address">Alamat Lengkap</label>
    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
        value="{{ old('address', $homestay->location ?? '') }}">
    <small class="form-text">Contoh: Jalan, RT/RW, Desa/Kelurahan (opsional)</small>
    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi *</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
        rows="5" required>{{ old('description', $homestay->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="max_guests">Kapasitas Maksimal Tamu *</label>
        <input type="number" id="max_guests" name="max_guests" class="form-control"
            value="{{ old('max_guests', $homestay->max_guests ?? 1) }}" min="1" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="price_per_night">Harga per Malam (Rp)</label>
        <input type="number" id="price_per_night" name="price_per_night" class="form-control"
            value="{{ old('price_per_night', $homestay->price_per_night ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — harga per malam</small>
    </div>

    <div class="form-group">
        <label for="price_per_month">Harga per Bulan (Rp)</label>
        <input type="number" id="price_per_month" name="price_per_month" class="form-control"
            value="{{ old('price_per_month', $homestay->price_per_month ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk kost/jangka panjang</small>
    </div>

    <div class="form-group">
        <label for="price_per_year">Harga per Tahun (Rp)</label>
        <input type="number" id="price_per_year" name="price_per_year" class="form-control"
            value="{{ old('price_per_year', $homestay->price_per_year ?? '') }}" step="1000" min="0">
        <small class="form-text text-muted">Opsional — untuk sewa tahunan</small>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="bedrooms">Jumlah Kamar Tidur *</label>
        <input type="number" name="bedrooms" id="bedrooms" class="form-control @error('bedrooms') is-invalid @enderror"
            min="1" value="{{ old('bedrooms', $homestay->bedrooms ?? 1) }}" required>
        @error('bedrooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label for="bathrooms">Jumlah Kamar Mandi *</label>
        <input type="number" name="bathrooms" id="bathrooms"
            class="form-control @error('bathrooms') is-invalid @enderror" min="1"
            value="{{ old('bathrooms', $homestay->bathrooms ?? 1) }}" required>
        @error('bathrooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
    <input type="text" name="amenities" id="amenities" class="form-control"
        value="{{ old('amenities', isset($homestay->amenities) ? implode(',', (array) $homestay->amenities) : '') }}"
        placeholder="Contoh: WiFi, AC, Dapur">
</div>

<div class="form-group">
    <label for="image_url">Foto Utama (Cover)</label>
    <div class="current-image">
        @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
            <a href="{{ asset('storage/' . $homestay->image_url) }}" target="_blank" rel="noopener">
                <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}" class="image-preview">
            </a>
            <p>Foto saat ini</p>
        @else
            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder" class="image-preview">
            <p class="text-muted">Belum ada foto</p>
        @endif
    </div>

    <div class="mt-2">
        <input type="file" id="image_url" name="image_url" accept="image/*" class="form-control">
        <small class="form-text">Format: JPG, PNG, GIF. Max 2MB (Kosongkan jika tidak ingin mengubah)</small>
    </div>

    <div class="mt-3">
        <label for="images">Gambar Tambahan (galeri)</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple class="form-control">
        <small class="form-text">Unggah beberapa gambar untuk galeri (opsional). Format: JPG, PNG, WEBP. Max 4MB per
            file.</small>
    </div>

    @if(!empty($homestay->images) && is_array($homestay->images) && count($homestay->images))
        <div class="mt-3">
            <label class="form-label">Gambar Galeri</label>
            <div class="d-flex gap-2 flex-wrap">
                @foreach($homestay->images as $img)
                    <div style="width:120px;text-align:center">
                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                            <img src="{{ asset('storage/' . $img) }}" alt="" class="image-preview-small">
                        @else
                            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="" class="image-preview-small">
                        @endif
                        <div class="form-check mt-1">
                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="remove_{{ md5($img) }}">
                            <label for="remove_{{ md5($img) }}" class="small">Hapus</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@if(\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured'))
    <div class="form-group form-check mt-3">
        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $homestay->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_featured">Tandai sebagai <strong>Kamar Pilihan</strong></label>
    </div>
@endif

<div class="form-group text-muted small">
    Gambar tambahan dapat diunggah saat edit atau melalui galeri homestay.
</div>
</div>