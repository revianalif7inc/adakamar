@extends('layouts.app')

@section('title', 'Manajemen Kamar - Owner')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kamar-management.css') }}">
@endsection

@section('content')
    <div class="admin-kamar-list">
        <div class="container">
            <div class="admin-kamar-header">
                <div>
                    <h1><i class="fas fa-door-open"></i> Daftar Kamar Saya</h1>
                    <p class="text-muted">Kelola kamar yang Anda tambahkan (menunggu konfirmasi admin jika belum aktif)</p>
                </div>
                <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Tambah Kamar Baru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            <div class="kamar-list-card">

                <div class="filters">
                    <form method="GET" action="{{ route('owner.kamar.index') }}" class="filters-form">
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
                            <option value="inactive" {{ (old('status', $status ?? request('status')) === 'inactive') ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        </select>

                        <a href="{{ route('owner.kamar.index') }}" class="btn btn-reset"><i class="fas fa-redo"></i>
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
                                    <a href="{{ route('owner.kamar.edit', $homestay->id) }}" class="btn btn-sm btn-edit">
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
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="kamar-card-info">
                                    <p class="kamar-date">
                                        <i class="fas fa-calendar-alt"></i> Ditambahkan
                                        {{ optional($homestay->created_at)->format('d M Y') }}
                                    </p>

                                    <div class="kamar-price">
                                        @if($homestay->price_per_month)
                                            <span class="price-label">Rp
                                                {{ number_format($homestay->price_per_month, 0, ',', '.') }}</span>
                                            <span class="price-period">/ bulan</span>
                                        @elseif($homestay->price_per_year)
                                            <span class="price-label">Rp
                                                {{ number_format($homestay->price_per_year, 0, ',', '.') }}</span>
                                            <span class="price-period">/ tahun</span>
                                        @else
                                            <span class="price-label text-muted">Harga belum tersedia</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="kamar-card-footer">
                                    <div class="kamar-actions">
                                        <a href="{{ route('kamar.show', $homestay->slug) }}" target="_blank"
                                            class="btn btn-sm btn-outline">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('owner.kamar.edit', $homestay->id) }}" class="btn btn-sm btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('owner.kamar.destroy', $homestay->id) }}" method="POST"
                                            class="d-inline" style="flex: 1;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete"
                                                style="width: 100%; justify-content: center;"
                                                onclick="return confirm('Hapus kamar?')">
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
                            <p class="text-muted">Belum ada kamar yang Anda tambahkan.</p>
                            <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus"></i> Tambah Kamar Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>
                <div class="pagination-wrapper">{{ $homestays->links() }}</div>
            </div>
        </div>
    </div>
@endsection