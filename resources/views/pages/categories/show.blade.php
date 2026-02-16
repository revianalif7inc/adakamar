@extends('layouts.app')

@section('title', $category->name . ' — Kategori')

@section('meta')
    <meta name="description"
        content="{{ \Illuminate\Support\Str::limit($category->description ?? ("Kategori " . $category->name), 160) }}">
    <link rel="canonical" href="{{ route('categories.show', $category->slug) }}">
    <link rel="stylesheet" href="{{ asset('css/categories-show.css') }}">
    <script type="application/ld+json">
        {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => $category->name,
        "description" => \Illuminate\Support\Str::limit($category->description ?? '', 160),
        "mainEntity" => [
            "@type" => "ItemList",
            "itemListElement" => $homestays->map(function ($h, $i) {
                return [
                    "@type" => "ListItem",
                    "position" => $i + 1,
                    "item" => [
                        "@id" => route('kamar.show', $h->slug),
                        "name" => $h->name,
                        "image" => !empty($h->image_url) ? asset('storage/' . $h->image_url) : asset('images/homestays/placeholder.svg'),
                        "description" => \Illuminate\Support\Str::limit($h->description ?? '', 120),
                    ]
                ];
            })->toArray()
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
@endsection

@section('content')
    <div class="category-page">
        <!-- Header -->
        <div class="category-header">
            <div class="header-container">
                <div class="header-wrapper">
                    <div class="header-top">
                        <a href="{{ route('categories.index') }}" class="back-link">
                            <i class="fas fa-chevron-left"></i> Kembali ke Kategori
                        </a>
                    </div>
                    <div class="header-content">
                        <h1 class="category-title">{{ $category->name }}</h1>
                        @if($category->description)
                            <p class="subtitle">{{ $category->description }}</p>
                        @endif
                        <div class="header-stats">
                            <span class="stat"><i class="fas fa-home"></i> {{ $homestays->total() }} unit tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container-fluid category-container">
            <div class="homestays-section">
                @if($homestays->count() > 0)
                    <div class="homestays-grid">
                        @foreach($homestays as $homestay)
                            <div class="kamar-card" data-id="{{ $homestay->id }}">
                                <!-- Image -->
                                <div class="card-image-wrapper">
                                    @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                        <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}"
                                            class="card-image" loading="lazy">
                                    @else
                                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder" class="card-image">
                                    @endif
                                    <div class="card-overlay"></div>
                                </div>

                                <!-- Content -->
                                <div class="card-content">
                                    <div class="card-header">
                                        <h3 class="card-title" title="{{ $homestay->name }}">
                                            {{ \Illuminate\Support\Str::limit($homestay->name, 45) }}</h3>
                                        @if($homestay->rating && $homestay->rating > 0)
                                            <div class="card-rating-badge">
                                                <span class="rating-value">★ {{ number_format($homestay->rating, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="card-location"><i class="fas fa-map-marker-alt"></i>
                                        {{ $homestay->location ?? 'Lokasi tidak tersedia' }}</p>
                                    <p class="card-description">{{ \Illuminate\Support\Str::limit($homestay->description, 85) }}</p>

                                    <!-- Features -->
                                    <div class="card-features">
                                        @if($homestay->bedrooms)
                                            <span class="feature-badge"><i class="fas fa-bed"></i> {{ $homestay->bedrooms }}</span>
                                        @endif
                                        @if($homestay->bathrooms)
                                            <span class="feature-badge"><i class="fas fa-bath"></i> {{ $homestay->bathrooms }}</span>
                                        @endif
                                    </div>

                                    <!-- Pricing -->
                                    <div class="card-pricing">
                                        @if($homestay->price_per_month)
                                            <span class="price-badge primary">Rp
                                                {{ number_format($homestay->price_per_month, 0, ',', '.') }}/bln</span>
                                        @elseif($homestay->price_per_year)
                                            <span class="price-badge primary">Rp
                                                {{ number_format($homestay->price_per_year, 0, ',', '.') }}/thn</span>
                                        @else
                                            <span class="price-badge secondary">Hubungi Pemilik</span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="card-actions">
                                        <a href="{{ route('kamar.show', $homestay->slug) }}"
                                            class="btn btn-view-detail">
                                            <span>Lihat Detail</span> <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($homestays->hasPages())
                        <div class="pagination-wrapper">
                            {{ $homestays->links() }}
                        </div>
                    @endif
                @else
                    <div class="no-results">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Tidak Ada Kamar Ditemukan</h3>
                        <p>Mohon maaf, kategori ini belum memiliki unit yang tersedia.</p>
                        <a href="{{ route('kamar.index') }}" class="btn btn-back-explore">
                            <i class="fas fa-arrow-left"></i> Jelajahi Kategori Lain
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection