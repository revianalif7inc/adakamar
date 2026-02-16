@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="hero-section">
        <div class="container">
            <div class="hero-row">
                <div class="hero-left animate-on-scroll">
                    <h1>Selamat Datang di AdaKamar</h1>
                    <p>Temukan dan sewa kamar terbaik di Indonesia</p>

                    <div class="hero-search">
                        <form action="{{ route('kamar.index') }}" method="GET" class="search-box" id="homeSearchForm">
                            <input type="text" name="search" class="form-control search-input"
                                placeholder="Cari kamar, lokasi, atau fasilitas..." value="{{ request('search') }}">

                            <select name="location_id" class="form-select search-select" id="homeLocationSelect">
                                <option value="">Semua Lokasi</option>
                                @foreach($topLocations as $loc)
                                    <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->name }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-search">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="hero-right d-none d-md-block">
                    <div class="hero-visual" aria-hidden="true">
                        <img src="{{ asset('images/homestays/placeholder.jpg') }}" alt="Ilustrasi homestay">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-kamar">
        <div class="container">
                <div class="card-slider-header animate-on-scroll">
                <div class="section-divider"></div>
                <h2>Kamar Pilihan</h2>
                <p class="text-muted">Pilihan kamar yang dipilih oleh admin untuk rekomendasi terbaik.</p>
            </div>
        </div>

        <div class="container">
            <div class="kamar-grid">
                @forelse($featuredHomestays->take(6) as $homestay)
                    <div class="kamar-card card-item h-100 shadow-sm animate-on-scroll">
                        <a class="card-link" href="{{ route('kamar.show', $homestay) }}">
                            <div class="kamar-image card-image">
                                @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                                    <img loading="lazy" src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}">
                                @else
                                    <img loading="lazy" src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                @endif
                                <div class="pin-badge" aria-hidden="true"><i class="fa fa-map-marker-alt"></i></div>
                            </div>

                            <div class="kamar-body card-body">
                                <div class="kamar-title-row">
                                    <h3 title="{{ $homestay->name }}">{{ \Illuminate\Support\Str::limit($homestay->name, 36) }}</h3>
                                </div>

                                <p class="excerpt">{{ \Illuminate\Support\Str::limit($homestay->description ?? 'Homestay nyaman dan bersih.', 90) }}</p>

                                <div class="dotted-divider" aria-hidden="true"></div>

                                <div class="card-meta d-flex align-items-center justify-content-center gap-4">
                                    @if($homestay->price_per_month)
                                        <div class="price-pill">Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan</div>
                                    @elseif($homestay->price_per_year)
                                        <div class="price-pill">Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun</div>
                                    @else
                                        <div class="price-pill text-muted">Harga belum tersedia</div>
                                    @endif
                                    <div class="badge-rating">★ {{ number_format($homestay->rating ?? 0, 2) }}</div>
                                </div>
                            </div>
                        </a>

                        <div class="kamar-actions p-3 d-flex gap-2 justify-content-center">
                            <a href="{{ route('kamar.show', $homestay) }}" class="btn btn-detail">Lihat Detail</a>
                            @auth
                                <a href="{{ route('booking.create', $homestay->slug) }}" class="btn btn-pesan">Pesan</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada kamar pilihan saat ini</p>
                @endforelse
            </div>
        </div>

        <div class="container">
            <div class="center-cta">
                <a href="{{ route('kamar.index') }}" class="btn btn-primary">Lihat Lainnya <span class="btn-icon"><i class="fa fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>

    <div class="card-slider-section">
        <div class="container">
            <div class="card-slider-header animate-on-scroll">
                <div class="section-divider"></div>
                <div class="section-stars">★ ★ ★</div>
                <h2>Homestay Jogja Terbaik</h2>
                <p>Nikmati Keseruan Bersama Rombongan Dengan Memilih Homestay Jogja Terbaik</p>
            </div>
        </div>

        <!-- Full-bleed slider wrapper -->
        <div class="card-slider-bleed">
            <div class="card-slider" data-slider-type="homestay" data-autoplay="4500" role="region"
                aria-label="Slider Homestay Terbaik">
                <div class="slider-nav prev"><button class="slider-button prev" aria-label="Sebelumnya"><i
                            class="fa fa-chevron-left"></i></button></div>
                <div class="slider-nav next"><button class="slider-button next" aria-label="Selanjutnya"><i
                            class="fa fa-chevron-right"></i></button></div>

                <div class="cards-track" role="list">
                    @forelse($jogjaTopHomestays as $h)
                        <a class="card-item" href="{{ route('kamar.show', $h) }}">
                            <div class="card-image">
                                @if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url))
                                    <img loading="lazy" src="{{ asset('storage/' . $h->image_url) }}" alt="{{ $h->name }}">
                                @else
                                    <img loading="lazy" src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                @endif
                            </div>

                            <div class="card-body">
                                <h3 title="{{ $h->name }}">{{ \Illuminate\Support\Str::limit($h->name, 36) }}</h3>
                                <div class="meta">
                                    <span class="location"><i class="fa fa-map-marker-alt icon-highlight"></i>{{ $h->location }}</span>
                                    <span class="meta-rooms">{{ $h->rooms ?? '—' }} kamar</span>
                                </div>
                                <p class="excerpt">
                                    {{ \Illuminate\Support\Str::limit($h->description ?? 'Homestay nyaman dan bersih, cocok untuk keluarga dan rombongan.', 110) }}
                                </p>

                                <div class="card-footer">
                                        @if($h->price_per_month)
                                            <div class="price-pill">Rp {{ number_format($h->price_per_month, 0, ',', '.') }} / bulan</div>
                                        @elseif($h->price_per_year)
                                            <div class="price-pill">Rp {{ number_format($h->price_per_year, 0, ',', '.') }} / tahun</div>
                                        @else
                                            <div class="price-pill text-muted">Harga belum tersedia</div>
                                        @endif
                                        <div class="badge-rating">★ {{ number_format($h->rating ?? 0, 2) }}</div>
                                    </div>
                            </div>
                        </a>
                    @empty
                        <p>Tidak ada homestay yang ditampilkan.</p>
                    @endforelse
                </div>

                <div class="slider-dots" aria-hidden="false"></div>

            </div>
        </div>

        <div class="container">
            <div class="center-cta">
                <a href="{{ route('kamar.index', ['search' => 'Yogyakarta']) }}" class="btn btn-primary">Lihat Lainnya <span class="btn-icon"><i
                            class="fa fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>


    <!-- Testimonials Slider -->
    <div class="testimonials-section">
        <div class="container">
            <div class="card-slider-header centered animate-on-scroll">
                <div class="section-divider"></div>
                <h2>Apa Kata Penghuni Kost</h2>
                <p class="text-muted">Testimoni tamu kami memberikan gambaran nyata tentang pengalaman menginap mereka.</p>
            </div>

            <div class="card-slider testimonials-slider" data-slider-type="testimonial" data-autoplay="6000" role="region"
                aria-label="Slider Testimoni Pengunjung">
                <div class="slider-nav prev"><button class="slider-button prev" aria-label="Sebelumnya"><i
                            class="fa fa-chevron-left"></i></button></div>
                <div class="slider-nav next"><button class="slider-button next" aria-label="Selanjutnya"><i
                            class="fa fa-chevron-right"></i></button></div>

                <div class="cards-track" role="list">
                    @forelse($testimonials as $t)
                        <div class="card-item testimonial-item">
                            <div class="card-body">
                                <p class="excerpt">
                                    "{{ \Illuminate\Support\Str::limit($t->comment ?? 'Pengalaman menginap yang menyenangkan.', 160) }}"
                                </p>
                                <div class="testimonial-meta">
                                    <div class="owner-avatar large">{{ strtoupper(substr($t->user->name ?? 'G', 0, 1)) }}</div>
                                    <div>
                                        <div class="owner-name">{{ $t->user->name ?? 'Tamu' }}
                                        </div>
                                        <div class="text-muted muted-small">di
                                            {{ $t->homestay->name ?? 'Homestay' }} • ★ {{ number_format($t->rating, 1) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Tidak ada testimoni tersedia.</p>
                    @endforelse
                </div>

                <div class="slider-dots" aria-hidden="false"></div>
            </div>
        </div>
    </div>


    <!-- About Us Section -->
    <div class="about-us-section">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-image animate-on-scroll">
                    <div class="about-image-container">
                        <img src="{{ asset('images/homestays/villaplaceholder.jpg') }}" alt="Villa Ada Kamar" class="about-main-image">
                        <div class="about-image-overlay"></div>
                    </div>
                </div>
                
                <div class="about-text-content animate-on-scroll">
                    <div class="about-heading">
                        <h2 class="about-title">Apa itu <span class="highlight-text">Ada Kamar</span>?</h2>
                    </div>
                    
                    <p class="about-description">
                        AdaKamar adalah perusahaan hospitality yang menawarkan pengalaman menginap dengan konsep bertamu ala Indonesia. 
                        Dengan tagline "Bertamu Ala Indonesia", di AdaKamar, Anda akan merasakan keramahtamahan khas Indonesia yang ditunjukkan 
                        oleh tuan rumah. Setiap unit pengingapan kami dilengkapi dengan fasilitas yang mencerminkan budaya lokal, memastikan 
                        kenyamanan dan suasana yang autentik selama Anda menginap.
                    </p>
                    
                    <a href="{{ route('about') }}" class="btn btn-primary btn-lg about-cta">
                        <span>Lebih lanjut</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Become Owner CTA -->
    <div class="become-owner-section">
        <div class="container">
            <div class="owner-wrapper">
                <div class="owner-image animate-on-scroll">
                    <div class="owner-image-container">
                        <img src="{{ asset('images/homestays/woman.jpg') }}" alt="Jadilah Owner AdaKamar" class="owner-main-image">
                    </div>
                </div>
                
                <div class="owner-text-content animate-on-scroll">
                    <div class="owner-heading">
                        <h2 class="owner-title">Yakin gamau sewa di Adakamar?</h2>
                    </div>
                    
                    <p class="owner-description">
                        Kami menawarkan fasilitas modern yang nyaman, keramahan khas Indonesia yang membuat Anda merasa seperti di rumah sendiri, lokasi strategis yang ideal untuk liburan atau perjalanan bisnis, harga terjangkau, sistem keamanan canggih untuk kenyamanan Anda, dan layanan profesional dari staf yang siap melayani dengan ramah.
                    </p>
                    
                    <a href="javascript:void(0)" class="btn btn-owner-cta owner-cta">
                        <span>Pesan Sekarang!</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/card-slider.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationSelect = document.getElementById('homeLocationSelect');
            if (locationSelect) {
                // Set size to force dropdown to show all options and open downward
                locationSelect.addEventListener('mousedown', function(e) {
                    this.size = Math.min(6, this.options.length);
                });
                locationSelect.addEventListener('change', function() {
                    this.size = 0; // Reset to normal
                });
                locationSelect.addEventListener('blur', function() {
                    this.size = 0; // Reset to normal
                });
            }
        });
    </script>
@endsection