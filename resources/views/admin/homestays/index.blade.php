@extends('layouts.app')

@section('title', 'Manajemen Kamar - Admin')

@section('content')
    <div class="admin-kamar-list">
        <div class="container">
            <!-- Header -->
            <div class="admin-kamar-header">
                <div>
                    <h1>Manajemen Kamar</h1>
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

            <!-- Kamar List Table -->
            <div class="kamar-list-card">

                <div class="filters">
                    <form method="GET" action="{{ route('admin.kamar.index') }}" class="filters-form">
                        <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}"
                            placeholder="Cari nama, lokasi atau deskripsi..." class="form-control" />

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

                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary">Reset</a>

                        <div class="ml-auto text-muted">Menampilkan {{ $homestays->total() }} kamar</div>
                    </form>
                </div>

                <div class="table-responsive-wrapper">
                    <table class="table table-kamar">
                        <thead>
                            <tr>
                                <th width="200">Nama Kamar</th>
                                <th width="80">Featured</th>
                                <th width="120">Kategori</th>
                                <th width="180">Pemilik</th>
                                <th width="150">Lokasi</th>
                                <th width="120">Harga</th>
                                <th width="80">Kamar</th>
                                <th width="80">Kapasitas</th>
                                <th width="80">Rating</th>
                                <th width="90">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($homestays as $homestay)
                                <tr>
                                    <td data-label="Nama Kamar">
                                        <div class="kamar-name-cell">
                                            @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                                <a href="{{ asset('storage/' . $homestay->image_url) }}" target="_blank"
                                                    rel="noopener">
                                                    <img src="{{ asset('storage/' . $homestay->image_url) }}"
                                                        alt="{{ $homestay->name }}" class="kamar-thumb-lg">
                                                </a>
                                            @else
                                                <a href="{{ asset('images/homestays/placeholder.svg') }}" target="_blank"
                                                    rel="noopener">
                                                    <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder"
                                                        class="kamar-thumb-lg">
                                                </a>
                                            @endif
                                            <div>
                                                <p class="kamar-name">{{ $homestay->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Featured">
                                        @if($homestay->is_featured)
                                            <span class="badge badge-success">Ya</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td data-label="Kategori">
                                        <span class="category-badge"
                                            title="{{ $homestay->categories->pluck('name')->implode(', ') }}">Kost</span>
                                    </td>
                                    <td data-label="Pemilik">
                                        @if($homestay->owner)
                                            <a
                                                href="{{ route('admin.users.edit', $homestay->owner->id) }}">{{ $homestay->owner->name }}</a>
                                            <br><small class="text-muted">{{ $homestay->owner->email }}</small>
                                        @else
                                            <small class="text-muted">—</small>
                                        @endif
                                    </td>
                                    <td data-label="Lokasi">
                                        <small class="text-muted">{{ $homestay->location }}</small>
                                    </td>
                                    <td data-label="Harga">
                                        @if($homestay->price_per_month)
                                            <strong class="price-display">Rp
                                                {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan</strong>
                                        @elseif($homestay->price_per_year)
                                            <strong class="price-display">Rp
                                                {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun</strong>
                                        @elseif($homestay->price_per_night)
                                            <strong class="price-display">Rp
                                                {{ number_format($homestay->price_per_night, 0, ',', '.') }} / malam</strong>
                                        @else
                                            <small class="text-muted">Harga belum tersedia</small>
                                        @endif
                                    </td>
                                    <td data-label="Kamar">
                                        <span class="badge badge-info">{{ $homestay->bedrooms }}</span>
                                    </td>
                                    <td data-label="Kapasitas">
                                        <span class="capacity-badge">{{ $homestay->max_guests }} <i
                                                class="fas fa-user"></i></span>
                                    </td>
                                    <td data-label="Rating">
                                        <span class="rating-display">
                                            @if($homestay->rating)
                                                <i class="fas fa-star rating-star"></i>
                                                {{ number_format($homestay->rating, 1) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        @if($homestay->is_active)
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.kamar.edit', $homestay->id) }}" class="btn btn-sm btn-edit"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.kamar.toggleFeature', $homestay->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $homestay->is_featured ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                                    title="Toggle Feature">
                                                    <i class="fas fa-thumbtack"></i>
                                                </button>
                                            </form>

                                            @if(!$homestay->is_active && $homestay->owner)
                                                <form action="{{ route('admin.kamar.confirm', $homestay->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-primary" title="Konfirmasi">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.kamar.destroy', $homestay->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-delete" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus kamar ini? Data yang sudah dihapus tidak bisa dipulihkan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center empty-state">
                                        <i class="fas fa-inbox empty-icon"></i>
                                        <p class="text-muted">Belum ada kamar. <a
                                                href="{{ route('admin.kamar.create') }}">Tambah kamar sekarang</a></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection