@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-tag"></i> Tambah Kategori</h1>
                    <p class="text-muted">Buat kategori baru untuk mengorganisir kamar</p>
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

                    <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Masukkan nama kategori" required>
                            <small class="form-text">Nama unik untuk kategori kamar</small>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug (opsional)</label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}"
                                placeholder="URL-friendly slug, kosongkan untuk auto-generate">
                            <small class="form-text">Gunakan huruf kecil, angka, dan tanda hubung. Kosongkan untuk generate
                                otomatis dari nama.</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="4"
                                placeholder="Jelaskan kategori ini...">{{ old('description') }}</textarea>
                            <small class="form-text">Deskripsi singkat tentang kategori (opsional)</small>
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="is_pinned" value="1"> Pin kategori (tampilkan lebih
                                dahulu)</label>
                        </div>

                        <div class="form-group">
                            <label for="sort_order">Urutan tampil (angka, lebih kecil tampil lebih awal)</label>
                            <input type="number" id="sort_order" name="sort_order" class="form-control"
                                value="{{ old('sort_order') }}">
                            <small class="form-text">Kosongkan untuk menempatkan di akhir</small>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Kategori
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