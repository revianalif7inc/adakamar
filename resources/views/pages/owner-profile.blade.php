@extends('layouts.app')

@section('title', $owner->name . ' - Profil Pemilik')

@section('content')
    <div class="owner-profile-page">
        {{-- Header Section --}}
        <div class="owner-header">
            <div class="container">
                <div class="owner-header-content">
                    <div class="owner-avatar-large">
                        {{ strtoupper(substr($owner->name, 0, 1)) }}
                    </div>
                    
                    <div class="owner-header-info">
                        <h1 class="owner-name">{{ $owner->name }}</h1>
                        <p class="owner-email">📧 {{ $owner->email }}</p>
                        @if($owner->phone)
                            <p class="owner-phone">📞 {{ $owner->phone }}</p>
                        @endif
                        
                        <div class="owner-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ $homestaysCount }}</span>
                                <span class="stat-label">Properti</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">★ {{ number_format($averageRating, 1) }}</span>
                                <span class="stat-label">Rating Rata-rata</span>
                            </div>
                            @if($locations->count() > 0)
                                <div class="stat-item">
                                    <span class="stat-number">{{ $locations->count() }}</span>
                                    <span class="stat-label">Lokasi</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="container owner-profile-container">
            {{-- Locations Filter --}}
            @if($locations->count() > 0)
                <div class="locations-filter">
                    <h3>Lokasi Properti</h3>
                    <div class="location-tags">
                        @foreach($locations as $location)
                            <span class="location-tag">📍 {{ $location }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Homestays Grid --}}
            <div class="owner-homestays-section">
                <h2 class="section-title">
                    <i class="fa fa-home"></i> Properti {{ $owner->name }}
                </h2>

                @if($homestays->count() > 0)
                    <div class="owner-homestays-grid">
                        @foreach($homestays as $homestay)
                            <div class="owner-homestay-card">
                                {{-- Image --}}
                                <div class="card-image-wrapper">
                                    @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                        <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}" class="card-image">
                                    @else
                                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder" class="card-image">
                                    @endif
                                    
                                    @if($homestay->is_featured)
                                        <span class="featured-badge">⭐ Unggulan</span>
                                    @endif
                                </div>

                                {{-- Card Content --}}
                                <div class="card-content">
                                    <h3 class="card-title" title="{{ $homestay->name }}">
                                        {{ \Illuminate\Support\Str::limit($homestay->name, 40) }}
                                    </h3>

                                    <p class="card-location">
                                        📍 {{ $homestay->location }}
                                    </p>

                                    <p class="card-description">
                                        {{ \Illuminate\Support\Str::limit($homestay->description, 90) }}
                                    </p>

                                    {{-- Amenities --}}
                                    <div class="card-amenities">
                                        <span class="amenity">🛏️ {{ $homestay->bedrooms }} Kamar</span>
                                        <span class="amenity">🚿 {{ $homestay->bathrooms }} Kamar Mandi</span>
                                        <span class="amenity">👥 {{ $homestay->max_guests }} Tamu</span>
                                    </div>

                                    {{-- Pricing --}}
                                    <div class="card-pricing">
                                        @if($homestay->price_per_night)
                                            <div class="price-option">
                                                <span class="price-label">Malam</span>
                                                <span class="price-value">Rp {{ number_format($homestay->price_per_night, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        @if($homestay->price_per_month)
                                            <div class="price-option">
                                                <span class="price-label">Bulan</span>
                                                <span class="price-value">Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                        @if($homestay->price_per_year)
                                            <div class="price-option">
                                                <span class="price-label">Tahun</span>
                                                <span class="price-value">Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Rating --}}
                                    <div class="card-rating">
                                        <span class="rating-badge">★ {{ number_format($homestay->rating ?? 0, 1) }}</span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="card-actions">
                                        <a href="{{ route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? '']) }}" 
                                           class="btn btn-primary">
                                            <i class="fa fa-eye"></i> Lihat Detail
                                        </a>
                                        @auth
                                            <a href="{{ route('booking.create', $homestay->slug) }}" 
                                               class="btn btn-secondary">
                                                <i class="fa fa-envelope"></i> Pesan
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-homestays">
                        <i class="fa fa-inbox"></i>
                        <p>Pemilik ini tidak memiliki properti yang tersedia saat ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/owner-profile.css') }}">
@endsection
