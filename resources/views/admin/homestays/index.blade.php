@extends('layouts.app')

@section('title', 'Manajemen Kamar - Admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kamar-management.css') }}">
@endsection

@section('content')
    <div class="admin-kamar-list">
        <div class="container">
            <!-- Header -->
            <div class="admin-kamar-header">
                <div>
                    <h1><i class="fas fa-door-open"></i> Manajemen Kamar</h1>
                    <p class="text-muted">Kelola semua kamar yang tersedia di platform</p>
                </div>
                <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Tambah Kamar Baru
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            <!-- Kamar List Grid -->
            <div class="kamar-list-card">

                <div class="filters">
                    <form method="GET" action="{{ route('admin.kamar.index') }}" class="filters-form">
                        <div class="search-input-wrapper">
                            <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}"
                                placeholder="Cari nama, lokasi atau deskripsi..." class="form-control" />
                            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                        </div>

                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category', $category ?? request('category')) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <select name="location_id" class="form-control">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ (old('location_id', $location ?? request('location_id')) == $loc->id) ? 'selected' : '' }}>{{ $loc->name }}</option>
                            @endforeach
                        </select>

                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="active" {{ (old('status', $status ?? request('status')) === 'active') ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ (old('status', $status ?? request('status')) === 'inactive') ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        <a href="{{ route('admin.kamar.index') }}" class="btn btn-reset"><i class="fas fa-redo"></i>
                            Reset</a>

                        <div class="filter-info">Total: <strong>{{ $homestays->total() }}</strong> kamar</div>
                    </form>
                </div>

                <div class="kamar-grid-container">
                    @forelse($homestays as $homestay)
                        <div class="kamar-card">
                            <div class="kamar-card-image">
                                @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                    <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}" />
                                @else
                                    <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder" />
                                @endif
                                <div class="kamar-card-overlay">
                                    <a href="{{ route('admin.kamar.edit', $homestay->id) }}" class="btn btn-sm btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>

                            <div class="kamar-card-content">
                                <div class="kamar-card-header">
                                    <h3 class="kamar-card-title">{{ $homestay->name }}</h3>
                                    <div class="kamar-status-badge">
                                        @if($homestay->is_active)
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="kamar-card-info">
                                    <p class="kamar-location">
                                        <i class="fas fa-map-marker-alt"></i> {{ $homestay->location }}
                                    </p>

                                    <div class="kamar-stats">
                                        <div class="stat-item">
                                            <span class="stat-value">{{ $homestay->bedrooms }}</span>
                                            <span class="stat-label">Kamar</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value">{{ $homestay->max_guests }}</span>
                                            <span class="stat-label">Kapasitas</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value">
                                                @if($homestay->rating)
                                                    <i class="fas fa-star"></i> {{ number_format($homestay->rating, 1) }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </span>
                                            <span class="stat-label">Rating</span>
                                        </div>
                                    </div>

                                    <div class="kamar-price">
                                        @if($homestay->price_per_month)
                                            <span class="price-label">Rp
                                                {{ number_format($homestay->price_per_month, 0, ',', '.') }}</span>
                                            <span class="price-period">/ bulan</span>
                                        @elseif($homestay->price_per_year)
                                            <span class="price-label">Rp
                                                {{ number_format($homestay->price_per_year, 0, ',', '.') }}</span>
                                            <span class="price-period">/ tahun</span>
                                        @elseif($homestay->price_per_night)
                                            <span class="price-label">Rp
                                                {{ number_format($homestay->price_per_night, 0, ',', '.') }}</span>
                                            <span class="price-period">/ malam</span>
                                        @else
                                            <span class="price-label text-muted">Harga belum tersedia</span>
                                        @endif
                                    </div>

                                    @if($homestay->owner)
                                        <div class="kamar-owner">
                                            <small><strong>{{ $homestay->owner->name }}</strong></small>
                                            <br><small class="text-muted">{{ $homestay->owner->email }}</small>
                                        </div>
                                    @endif
                                </div>

                                <div class="kamar-card-footer">
                                    <div class="kamar-actions">
                                        <form action="{{ route('admin.kamar.toggleFeature', $homestay->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-sm {{ $homestay->is_featured ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                                title="Toggle Feature">
                                                <i class="fas fa-thumbtack"></i>
                                                {{ $homestay->is_featured ? 'Featured' : 'Feature' }}
                                            </button>
                                        </form>

                                        @if(!$homestay->is_active && $homestay->owner)
                                            <form action="{{ route('admin.kamar.confirm', $homestay->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-primary" title="Konfirmasi">
                                                    <i class="fas fa-check"></i> Konfirmasi
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.kamar.destroy', $homestay->id) }}" method="POST"
                                            class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus kamar ini? Data yang sudah dihapus tidak bisa dipulihkan.')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-full">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p class="text-muted">Belum ada kamar. <a href="{{ route('admin.kamar.create') }}">Tambah kamar
                                    sekarang</a></p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection