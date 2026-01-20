@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Edit Kamar</h1>
                    <p class="text-muted">Perbarui informasi kamar — nama, harga, gambar, dan fasilitas</p>
                </div>
                <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>

            <div class="admin-section">
                <div class="section-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <form action="{{ route('admin.kamar.update', $homestay->id) }}" method="POST"
                        enctype="multipart/form-data" class="form-kamar">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Kamar *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $homestay->name) }}"
                                class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug (opsional)</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $homestay->slug) }}"
                                class="form-control" placeholder="Contoh: kamar-bagus-1">
                            <small class="form-text">Kosongkan untuk auto-generate berdasarkan nama. Hanya huruf, angka dan
                                dash (-)
                                yang diperbolehkan.</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="categories">Kategori * (pilih lebih dari satu)</label>
                                <select id="categories" name="categories[]" class="form-control" multiple required>
                                    @php $selectedCats = old('categories', $homestay->categories->pluck('id')->toArray()); @endphp
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text">Gunakan Ctrl/Cmd atau Shift untuk memilih beberapa
                                    kategori.</small>

                                <div class="form-text mt-1">Atau ketik kategori baru:</div>
                                <input list="category-list" name="category_name" id="category_name"
                                    class="form-control mt-1" placeholder="Contoh: Kost"
                                    value="{{ old('category_name', '') }}">
                                <datalist id="category-list">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}"></option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="location_id">Lokasi/Alamat *</label>
                                <select id="location_id" name="location_id" class="form-control" required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc->id }}" {{ old('location_id', $homestay->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @section('css')
                            <link rel="stylesheet"
                                href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
                        @endsection

                        @section('js')
                            <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    document.querySelectorAll('select[name="categories[]"]').forEach(function (el) {
                                        if (!el.classList.contains('choices-initialized')) {
                                            new Choices(el, {
                                                removeItemButton: true,
                                                searchEnabled: true,
                                                shouldSort: false,
                                                placeholderValue: 'Pilih kategori...'
                                            });
                                            el.classList.add('choices-initialized');
                                        }
                                    });
                                });
                            </script>
                        @endsection

                        <div class="form-group">
                            <label for="address">Alamat Lengkap (contoh: Jalan, RT/RW, Desa/Kelurahan)</label>
                            <input type="text" id="address" name="address" class="form-control"
                                value="{{ old('address', $homestay->location) }}"
                                placeholder="Masukkan alamat lengkap yang akan tampil di listing">
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi *</label>
                            <textarea id="description" name="description" rows="5" class="form-control"
                                required>{{ old('description', $homestay->description) }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="max_guests">Kapasitas Maksimal Tamu *</label>
                                <input type="number" id="max_guests" name="max_guests" class="form-control"
                                    value="{{ old('max_guests', $homestay->max_guests) }}" min="1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price_per_night">Harga per Malam (Rp)</label>
                                <input type="number" id="price_per_night" name="price_per_night" class="form-control"
                                    value="{{ old('price_per_night', $homestay->price_per_night) }}" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — harga per malam</small>
                            </div>

                            <div class="form-group">
                                <label for="price_per_month">Harga per Bulan (Rp)</label>
                                <input type="number" id="price_per_month" name="price_per_month" class="form-control"
                                    value="{{ old('price_per_month', $homestay->price_per_month) }}" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — untuk kos/jangka panjang</small>
                            </div>

                            <div class="form-group">
                                <label for="price_per_year">Harga per Tahun (Rp)</label>
                                <input type="number" id="price_per_year" name="price_per_year" class="form-control"
                                    value="{{ old('price_per_year', $homestay->price_per_year) }}" step="1000" min="0">
                                <small class="form-text text-muted">Opsional — untuk sewa tahunan</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="bedrooms">Jumlah Kamar Tidur *</label>
                                <input type="number" id="bedrooms" name="bedrooms" class="form-control"
                                    value="{{ old('bedrooms', $homestay->bedrooms) }}" min="1" required>
                            </div>

                            <div class="form-group">
                                <label for="bathrooms">Jumlah Kamar Mandi *</label>
                                <input type="number" id="bathrooms" name="bathrooms" class="form-control"
                                    value="{{ old('bathrooms', $homestay->bathrooms) }}" min="1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image_url">Foto Utama (Cover)</label>
                            <div class="current-image">
                                @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                    <a href="{{ asset('storage/' . $homestay->image_url) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}">
                                    </a>
                                    <p>Foto saat ini</p>
                                @else
                                    <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                    <p class="text-muted">Belum ada foto</p>
                                @endif
                            </div>
                            <div class="mt-2">
                                <input type="file" id="image_url" name="image_url" accept="image/*" class="form-control">
                                <small class="form-text">Format: JPG, PNG, GIF. Max 2MB (Kosongkan jika tidak ingin
                                    mengubah)</small>
                            </div>

                            <div class="mt-3">
                                <label for="images">Gambar Tambahan (galeri)</label>
                                <input type="file" id="images" name="images[]" accept="image/*" multiple class="form-control">
                                <small class="form-text">Unggah gambar tambahan untuk galeri (opsional). Anda juga dapat menghapus gambar di bawah.</small>

                                @if(!empty($homestay->images) && is_array($homestay->images) && count($homestay->images))
                                    <div class="existing-images mt-2 d-flex gap-2 flex-wrap">
                                        @foreach($homestay->images as $img)
                                            <div class="existing-image-item text-center" style="width:120px;">
                                                @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                                    <img src="{{ asset('storage/' . $img) }}" alt="img" class="image-preview-small">
                                                @else
                                                    <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="img" class="image-preview-small">
                                                @endif
                                                <div class="form-check mt-1">
                                                    <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="remove_{{ md5($img) }}">
                                                    <label for="remove_{{ md5($img) }}" class="small">Hapus</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="amenities">Fasilitas (pisahkan dengan koma)</label>
                            <textarea id="amenities" name="amenities" rows="3" class="form-control"
                                placeholder="Contoh: WiFi, AC, Dapur, Kolam Renang...">{{ old('amenities', implode(', ', $homestay->amenities ?? [])) }}</textarea>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $homestay->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Tandai sebagai <strong>Kamar
                                    Pilihan</strong></label>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary">Perbarui Kamar</button>
                            <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection