@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-map-marker-alt"></i> Tambah Lokasi</h1>
                    <p class="text-muted">Buat lokasi baru untuk mengorganisir kamar</p>
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

                    <form action="{{ route('admin.locations.store') }}" method="POST" class="admin-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Lokasi</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Masukkan nama lokasi" required>
                            <small class="form-text">Nama unik untuk lokasi kamar</small>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" rows="4"
                                placeholder="Jelaskan lokasi ini...">{{ old('description') }}</textarea>
                            <small class="form-text">Deskripsi singkat tentang lokasi (opsional)</small>
                        </div>

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Lokasi
                            </button>
                            <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection