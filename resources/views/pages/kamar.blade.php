@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
    <div class="kamar-page">
        <div class="kamar-header">
            <div class="container">
                <h1>Daftar Kamar</h1>
            </div>
        </div>

        <div class="kamar-layout">
            <aside class="kamar-sidebar">
                    <div class="filters">
                        <h3>Filter</h3>
                        <form method="GET" action="{{ route('kamar.index') }}" class="filter-form">
                            <input type="text" name="search" placeholder="Cari kamar..." value="{{ request('search') }}">

                            <select name="location_id">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" name="min_price" placeholder="Min harga" value="{{ request('min_price') }}">
                            <input type="number" name="max_price" placeholder="Max harga" value="{{ request('max_price') }}">

                            <select name="sort">
                                <option value="">Urutkan</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi
                                </option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>

                    @if(isset($categories) && $categories->count())
                        <div class="categories-section">
                            <div class="section-header">
                                <div>
                                    <h3>Kategori</h3>
                                </div>
                                <div class="section-actions">
                                    @if(request('category'))
                                        <a href="{{ route('kamar.index', request()->except(['page', 'category'])) }}"
                                            class="btn btn-outline">Hapus Filter</a>
                                    @endif
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline">Semua Kategori</a>
                                </div>
                            </div>

                            <div class="categories-chips" role="tablist" aria-label="Filter Kategori">
                                <a href="{{ route('kamar.index', request()->except(['page', 'category'])) }}"
                                    class="category-chip {{ !request('category') ? 'active' : '' }}"
                                    aria-pressed="{{ !request('category') ? 'true' : 'false' }}">Semua <span
                                        class="cat-count">{{ $homestays->total() }}</span></a>

                                @foreach($categories as $category)
                                    <a href="{{ route('kamar.index', array_merge(request()->except(['page', 'category']), ['category' => $category->slug])) }}"
                                        class="category-chip {{ request('category') == $category->slug ? 'active' : '' }}"
                                        aria-pressed="{{ request('category') == $category->slug ? 'true' : 'false' }}">
                                        <span class="chip-icon">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                        <span class="chip-name">{{ $category->name }}</span>
                                        <span class="chip-count">{{ $category->homestays_count }}</span>
                                    </a>
                                @endforeach
                            </div>

                            <div class="categories-grid">
                                @foreach($categories as $category)
                                    <a href="{{ route('kamar.index', array_merge(request()->except(['page', 'category']), ['category' => $category->slug])) }}"
                                        class="category-card {{ request('category') == $category->slug ? 'active' : '' }}" role="link"
                                        aria-label="Kategori {{ $category->name }}">
                                        <div class="cat-icon">{{ strtoupper(substr($category->name, 0, 1)) }}</div>

                                        <div class="cat-body">
                                            <h4>{{ $category->name }}</h4>
                                            @if(!empty($category->description))
                                                <p class="cat-desc">{{ \Illuminate\Support\Str::limit($category->description, 80) }}</p>
                                            @endif
                                        </div>

                                        <div class="category-meta">
                                            <span class="category-count" aria-hidden="true">{{ $category->homestays_count }} unit</span>
                                        </div>

                                        <div class="card-arrow" aria-hidden="true"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                <main class="kamar-main">

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
                        <div class="card-meta">
                            @if($homestay->price_per_month)
                                <div class="price-pill">Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan</div>
                            @elseif($homestay->price_per_year)
                                <div class="price-pill">Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun</div>
                            @else
                                <div class="price-pill text-muted">Harga belum tersedia</div>
                            @endif
                            <div class="badge-rating">★ {{ number_format($homestay->rating ?? 0, 1) }}</div>
                        </div>

                        <div class="owner-meta">
                            <div class="owner-avatar">{{ strtoupper(substr($homestay->owner->name ?? 'A', 0, 1)) }}</div>
                            <div class="owner-info">
                                <p class="owner-name" title="{{ $homestay->owner->name ?? 'AdaKamar' }}">
                                    {{ \Illuminate\Support\Str::limit($homestay->owner->name ?? 'AdaKamar', 22) }}
                                </p>
                            </div>
                        </div>

                        <div class="kamar-card-actions">
                            <a href="{{ route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? '']) }}"
                                class="btn btn-detail">
                                <i class="fa fa-eye"></i> Lihat Detail
                            </a>
                            @auth
                                <a href="{{ route('booking.create', $homestay->id) }}" class="btn btn-pesan">
                                    <i class="fa fa-envelope"></i> Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <p class="no-results">Tidak ada kamar yang ditemukan</p>
                @endforelse
            </div>

            {{ $homestays->links() }}
        </main>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/kamar.css') }}">
@endsection