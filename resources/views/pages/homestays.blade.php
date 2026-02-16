@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
    <div class="kamar-page">
        <div class="container">
            <h1>Daftar Kamar</h1>

            <div class="filters">
                <form method="GET" action="{{ route('kamar.index') }}" class="filter-form">
                    <input type="text" name="search" placeholder="Cari kamar..." value="{{ request('search') }}">
                    <select name="sort">
                        <option value="">Urutkan</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>

            <div class="kamar-grid">
                @forelse($homestays as $homestay)
                    <div class="kamar-card">
                        @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                            <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}">
                        @else
                            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                        @endif

                        <h3 title="{{ $homestay->name }}">{{ \Illuminate\Support\Str::limit($homestay->name, 36) }}</h3>
                        <p class="location">📍 {{ $homestay->location }}</p>
                        <p class="description">{{ \Illuminate\Support\Str::limit($homestay->description, 100) }}</p>
                        <div class="kamar-info">
                            <span>🛏️ {{ $homestay->bedrooms }} Kamar</span>
                            <span>🚿 {{ $homestay->bathrooms }} Kamar Mandi</span>
                            <span>👥 Maks {{ $homestay->max_guests }} Tamu</span>
                        </div>
                        @if($homestay->price_per_month)
                            <p class="price">Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan</p>
                        @elseif($homestay->price_per_year)
                            <p class="price">Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun</p>
                        @else
                            <p class="price text-muted">Harga belum tersedia</p>
                        @endif
                        <p class="rating">⭐ {{ $homestay->rating ?? 'Belum dinilai' }}</p>

                        <div class="owner-meta">
                            <div class="owner-avatar">{{ strtoupper(substr($homestay->owner->name ?? 'A', 0, 1)) }}</div>
                            <div class="owner-info">
                                <p class="owner-name" title="{{ $homestay->owner->name ?? 'AdaKamar' }}">
                                    {{ \Illuminate\Support\Str::limit($homestay->owner->name ?? 'AdaKamar', 22) }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('kamar.show', $homestay->slug) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                @empty
                    <p class="no-results">Tidak ada kamar yang ditemukan</p>
                @endforelse
            </div>

            {{ $homestays->links() }}
        </div>
    </div>
@endsection