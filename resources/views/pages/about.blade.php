@extends('layouts.app')

@section('title', 'Tentang Kami - AdaKamar')

@section('content')
    <!-- About Hero Section -->
    <div class="about-hero-section">
        <div class="container">
            <div class="about-hero-content">
                <h1>Tentang <span class="highlight">AdaKamar</span></h1>
                <p class="lead">Bertamu Ala Indonesia — Pengalaman Menginap yang Autentik dan Ramah</p>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="about-mission-section py-5">
        <div class="container">
            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misi Kami</h3>
                    <p>
                        Menyediakan platform yang memudahkan setiap orang menemukan kamar nyaman dengan harga terjangkau
                        dan melayani pemilik kamar untuk memperluas jangkauan bisnis mereka di seluruh Indonesia.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visi Kami</h3>
                    <p>
                        Menjadi platform penginapan terdepan di Indonesia yang menghubungkan jutaan tamu dengan
                        ribuan pemilik kamar berkualitas, menciptakan ekosistem hospitality yang berkelanjutan dan saling
                        menguntungkan.
                    </p>
                </div>

                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Nilai Kami</h3>
                    <p>
                        Keramahan, kepercayaan, keberlanjutan, dan inovasi adalah fondasi setiap keputusan kami.
                        Kami percaya pada kekuatan budaya lokal dan keramahan Indonesia untuk menciptakan pengalaman tak
                        terlupakan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="about-story-section py-5">
        <div class="container">
            <div class="story-row">
                <div class="story-left">
                    <h2>Cerita Kami</h2>
                    <p>
                        AdaKamar lahir dari visi sederhana namun kuat: membuat mencari tempat menginap menjadi mudah,
                        terjangkau, dan menyenangkan. Kami memulai dengan percaya bahwa setiap orang berhak mendapatkan
                        kamar berkualitas dengan harga yang wajar.
                    </p>
                    <p>
                        Dengan motto "Bertamu Ala Indonesia", kami ingin menampilkan keramahan dan kehangatan
                        budaya Indonesia kepada setiap tamu. Setiap kamar di platform kami telah dipilih dan
                        diverifikasi untuk memastikan standar kualitas dan kenyamanan yang tinggi.
                    </p>
                    <p>
                        Hari ini, AdaKamar telah membantu ribuan tamu menemukan rumah sementara mereka dan
                        memberikan peluang bisnis kepada pemilik kamar di berbagai kota di Indonesia.
                    </p>
                </div>
                <div class="story-right">
                    <div class="story-image">
                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="Cerita AdaKamar" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="about-why-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Mengapa Memilih AdaKamar?</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Kamar Terverifikasi</h4>
                    <p>Semua kamar telah melewati verifikasi ketat untuk memastikan kualitas dan keamanan</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h4>Harga Transparan</h4>
                    <p>Tidak ada biaya tersembunyi. Harga yang Anda lihat adalah harga yang Anda bayar</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Dukungan 24/7</h4>
                    <p>Tim support kami siap membantu Anda kapan saja melalui WhatsApp dan email</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Jangkauan Luas</h4>
                    <p>Tersedia di berbagai kota di Indonesia dengan pilihan yang terus berkembang</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4>Rating & Review</h4>
                    <p>Baca ulasan asli dari tamu sebelumnya untuk membantu Anda memilih</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4>Aman & Terpercaya</h4>
                    <p>Transaksi Anda dijamin aman dengan sistem pembayaran yang terenkripsi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="about-stats-section py-5 bg-primary text-white">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3 class="stat-number">1000+</h3>
                    <p>Kamar Tersedia</p>
                </div>
                <div class="stat-item">
                    <h3 class="stat-number">5000+</h3>
                    <p>Tamu Puas</p>
                </div>
                <div class="stat-item">
                    <h3 class="stat-number">50+</h3>
                    <p>Kota di Indonesia</p>
                </div>
                <div class="stat-item">
                    <h3 class="stat-number">4.8★</h3>
                    <p>Rating Kepuasan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="about-values-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Komitmen Kami</h2>
            <div class="values-row">
                <div class="value-item">
                    <div class="value-number">01</div>
                    <h4>Kualitas Terjamin</h4>
                    <p>
                        Kami berkomitmen untuk hanya menampilkan kamar yang memenuhi standar kebersihan,
                        keamanan, dan kenyamanan yang ketat.
                    </p>
                </div>

                <div class="value-item">
                    <div class="value-number">02</div>
                    <h4>Harga Kompetitif</h4>
                    <p>
                        Kami bekerja dengan para pemilik kamar untuk menawarkan harga terbaik tanpa
                        mengorbankan kualitas layanan.
                    </p>
                </div>

                <div class="value-item">
                    <div class="value-number">03</div>
                    <h4>Transparansi Penuh</h4>
                    <p>
                        Semua informasi kamar, fasilitas, dan harga ditampilkan dengan jelas dan akurat
                        untuk membantu Anda membuat keputusan terbaik.
                    </p>
                </div>

                <div class="value-item">
                    <div class="value-number">04</div>
                    <h4>Dukung Lokal</h4>
                    <p>
                        Kami bangga mendukung pengusaha lokal dan bisnis kecil di seluruh Indonesia
                        untuk berkembang melalui platform kami.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA Section -->
    <div class="about-cta-section py-5 bg-light">
        <div class="container text-center">
            <h2>Ada Pertanyaan?</h2>
            <p class="lead mb-4">Hubungi kami melalui berbagai channel untuk informasi lebih lanjut</p>
            <div class="cta-buttons">
                @php
                    $waNumber = env('WHATSAPP_NUMBER', '628123456789');
                    $waMessage = urlencode('Halo AdaKamar, saya ingin bertanya tentang layanan Anda.');
                @endphp
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" class="btn btn-success btn-lg" target="_blank"
                    rel="noopener">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="mailto:info@adakamar.com" class="btn btn-primary btn-lg">
                    <i class="fas fa-envelope"></i> Email
                </a>
                <a href="{{ route('kamar.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-search"></i> Cari Kamar
                </a>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endsection