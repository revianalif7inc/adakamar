@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-tag"></i> Edit Kategori</h1>
                    <p class="text-muted">Perbarui informasi kategori {{ $category->name }}</p>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="admin-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Kategori *</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" placeholder="Masukkan nama kategori" required>
                            <small class="form-text">Nama unik untuk kategori kamar</small>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug (opsional)</label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $category->slug) }}"
                                placeholder="URL-friendly slug, kosongkan untuk auto-generate">
                            <small class="form-text">Gunakan huruf kecil, angka, dan tanda hubung. Kosongkan untuk generate
                                otomatis dari nama.</small>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description"
                                class="form-control @error('description') is-invalid @enderror" rows="4"
                                placeholder="Jelaskan kategori ini...">{{ old('description', $category->description) }}</textarea>
                            <small class="form-text">Deskripsi singkat tentang kategori (opsional)</small>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="sort_order">Urutan Tampil</label>
                                <input type="number" id="sort_order" name="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', $category->sort_order) }}" placeholder="0">
                                <small class="form-text">Angka lebih kecil tampil lebih awal (kosongkan untuk di
                                    akhir)</small>
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="is_pinned" class="form-check-label">
                                    <input type="hidden" name="is_pinned" value="0">
                                    <input type="checkbox" id="is_pinned" name="is_pinned" value="1"
                                        class="form-check-input" {{ old('is_pinned', $category->is_pinned) ? 'checked' : '' }}>
                                    <span class="ms-2"><strong>Pin kategori</strong> (tampilkan lebih dahulu)</span>
                                </label>
                            </div>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Perbarui Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection