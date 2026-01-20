@extends('layouts.app')

@section('title', 'Detail Kamar')

@section('content')
    <div class="kamar-detail">
        <div class="container">
            <div class="detail-tabs">
                <a href="#gallery" class="tab-link active">Gallery</a>
                <a href="#detail" class="tab-link">Detail</a>
                <a href="#fasilitas" class="tab-link">Fasilitas</a>
                <a href="#reviews" class="tab-link">Reviews</a>
            </div>

            <div class="detail-grid">
                <div class="detail-left">
                    <section id="gallery" class="gallery-section">
                        <div class="image-slider-container">
                            <div class="image-slider-wrapper">
                                <div class="image-slider" id="imageSlider">
                                    @php
                                        $images = $homestay->gallery ?? [];
                                    @endphp

                                    @forelse($images as $img)
                                        <div class="image-slider-item">
                                            @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $homestay->name }}">
                                            @else
                                                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                            @endif
                                        </div>
                                    @empty
                                        <div class="image-slider-item">
                                            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="slider-nav-button prev" id="prevBtn" aria-label="Previous image">❮</button>
                                <button type="button" class="slider-nav-button next" id="nextBtn" aria-label="Next image">❯</button>
                            </div>

                            <div class="thumbnail-strip" id="thumbStrip">
                                @foreach($images as $idx => $img)
                                    <div class="thumb-item" data-index="{{ $idx }}" role="button" tabindex="0">
                                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                            <img src="{{ asset('storage/' . $img) }}" alt="thumb-{{ $idx }}">
                                        @else
                                            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="thumb-placeholder">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </section>

                    <section id="detail" class="content-section">
                        <h2>{{ $homestay->name }}</h2>
                        <p class="location">📍 {{ $homestay->location }}</p>
                        <p class="rating">⭐ Rating: {{ $homestay->rating ?? 'Belum dinilai' }}</p>

                        <h3>Deskripsi</h3>
                        <p class="description-text">{{ $homestay->description }}</p>
                    </section>

                    <section id="fasilitas" class="content-section">
                        <h3>Fasilitas</h3>
                        <div class="facilities-grid">
                            @foreach($homestay->amenities ?? [] as $amenity)
                                <div class="facility-item">✓ {{ $amenity }}</div>
                            @endforeach
                        </div>

                        <h3 class="mt-4">Detail Kamar</h3>
                        <ul class="room-info">
                            <li>🛏️ Kamar Tidur: {{ $homestay->bedrooms }}</li>
                            <li>🚿 Kamar Mandi: {{ $homestay->bathrooms }}</li>
                            <li>👥 Kapasitas Maksimal: {{ $homestay->max_guests }} Tamu</li>
                        </ul>

                        <h3 class="mt-4">Detail Lengkap</h3>
                        <div class="detail-full">
                            {!! nl2br(e($homestay->description)) !!}
                        </div>
                    </section>

                    <section id="reviews" class="content-section reviews-section">
                        <h3>Ulasan Tamu</h3>

                        {{-- Review submission form (only for authenticated users with confirmed/completed booking) --}}
                        @auth
                            @php
                                $canReview = auth()->user()->bookings()->where('homestay_id', $homestay->id)->whereIn('status', ['confirmed', 'completed'])->exists();
                            @endphp

                            @if($canReview)
                                <div class="review-form">
                                    <h4>Berikan Ulasan Anda</h4>

                                    @if(session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    <form action="{{ route('reviews.store', ['id' => $homestay->id]) }}" method="POST" id="reviewForm">
                                        @csrf
                                        <input type="hidden" name="rating" id="reviewRating" value="{{ $userReview->rating ?? 0 }}">

                                        <div class="star-picker">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fas fa-star rating-star star-toggle" data-value="{{ $i }}"></i>
                                            @endfor
                                        </div>

                                        <div class="form-group mt-2">
                                            <textarea name="comment" class="form-control" placeholder="Tulis komentar (opsional)">{{ $userReview->comment ?? '' }}</textarea>
                                        </div>

                                        <div class="mt-2">
                                            <button class="btn btn-primary">Kirim Ulasan</button>
                                            @if($userReview)
                                                <small class="text-muted ms-2">Anda dapat mengubah ulasan Anda kapan saja.</small>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-info">Anda hanya dapat memberi ulasan setelah melakukan booking dan mendapatkan konfirmasi / selesai.</div>
                            @endif
                        @else
                            <p><a href="{{ route('login') }}">Masuk</a> untuk memberi ulasan.</p>
                        @endauth

                        {{-- Existing reviews list --}}
                        <div class="mt-4">
                            @if($reviews->isEmpty())
                                <p>Belum ada ulasan untuk kamar ini</p>
                            @endif

                            @foreach($reviews as $review)
                                <div class="review-card">
                                    <h4>{{ $review->user->name }}</h4>
                                    <p class="rating">@for($s = 0; $s < 5; $s++) <i class="fas fa-star rating-star" style="opacity: {{ $s < $review->rating ? '1' : '0.25' }}"></i> @endfor <strong>{{ $review->rating }}</strong> / 5</p>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>

                    </section>
                </div>

                <aside class="detail-right">
                    <div class="aside-sticky" id="asideSticky">
                        <div class="booking-card" data-price-month="{{ $homestay->price_per_month ?? '' }}" data-price-year="{{ $homestay->price_per_year ?? '' }}">
                            <h4>{{ $homestay->name }}</h4>
                            @if($homestay->price_per_month)
                                <p class="price">Mulai <strong>Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }}</strong> / bulan</p>
                            @elseif($homestay->price_per_year)
                                <p class="price">Mulai <strong>Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }}</strong> / tahun</p>
                            @elseif($homestay->price_per_night)
                                <p class="price">Rp {{ number_format($homestay->price_per_night, 0, ',', '.') }} / malam</p>
                            @else
                                <p class="price text-muted">Harga belum tersedia — hubungi pemilik</p>
                            @endif

                            <div class="callout">Pilih tanggal dan durasi sewa untuk melihat total harga.</div>

                            <form method="POST" action="{{ route('booking.store') }}" id="inlineBookingForm">
                                @csrf
                                <input type="hidden" name="homestay_id" value="{{ $homestay->id }}">

                                <div class="booking-form-row">
                                    <label for="booking_date">Tanggal Booking</label>
                                    <input type="date" name="booking_date" id="booking_date" required>
                                    @error('booking_date') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="booking-form-row duration-row">
                                    <label for="duration">Durasi</label>
                                    <input type="number" name="duration" id="duration" min="1" value="1" required>
                                    <select name="duration_unit" id="duration_unit" class="duration-unit">
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                    </select>
                                    @error('duration') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="booking-form-row">
                                    <label for="total_guests">Jumlah Tamu</label>
                                    <input type="number" name="total_guests" id="total_guests" min="1" value="1" required>
                                    @error('total_guests') <div class="field-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="booking-summary">
                                    <p>Durasi: <span id="durationSummary">-</span></p>
                                    <p>Total: <strong id="totalPrice">Rp -</strong></p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block" id="inlineBookingSubmit">
                                    <i class="fa fa-check-circle"></i> Pesan Sekarang
                                </button>
                            </form>

                            <div class="booking-meta">
                                <p class="muted">Atau hubungi pemilik:</p>
                                @if($homestay->owner)
                                    <div class="owner-box">
                                        <div class="owner-avatar">{{ strtoupper(substr($homestay->owner->name, 0, 1)) }}</div>
                                        <div class="owner-info">
                                            <p class="owner-name">{{ $homestay->owner->name }}</p>
                                            <p class="owner-contact">{{ $homestay->owner->phone ?? $homestay->owner->email }}
                                            </p>
                                            <a href="{{ route('admin.users.edit', $homestay->owner->id) }}"
                                                class="btn btn-sm btn-outline">View Profile</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="nearby-card">
                            <h5>Homestay Terdekat</h5>
                            <ul class="nearby-list">
                                @php $nearby = \App\Models\Homestay::where('location', $homestay->location)->where('id', '!=', $homestay->id)->limit(3)->get(); @endphp
                                @foreach($nearby as $n)
                                    <li>
                                        <a href="{{ route('kamar.show', ['id' => $n->id, 'slug' => $n->slug ?? '']) }}">
                                            @if(!empty($n->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($n->image_url))
                                                <img src="{{ asset('storage/' . $n->image_url) }}" alt="{{ $n->name }}">
                                            @else
                                                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                            @endif
                                            <div class="nearby-text">
                                                <p class="n-name">{{ \Illuminate\Support\Str::limit($n->name, 36) }}</p>
                                                @if($n->price_per_month)
                                                    <p class="n-price">Rp {{ number_format($n->price_per_month, 0, ',', '.') }} / bulan</p>
                                                @elseif($n->price_per_year)
                                                    <p class="n-price">Rp {{ number_format($n->price_per_year, 0, ',', '.') }} / tahun</p>
                                                @elseif($n->price_per_night)
                                                    <p class="n-price">Rp {{ number_format($n->price_per_night, 0, ',', '.') }} / malam</p>
                                                @else
                                                    <p class="n-price text-muted">Harga belum tersedia</p>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/image-slider.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('inlineBookingForm');
            if (!form) return;

            const pricePerMonth = parseFloat(form.closest('.booking-card').dataset.priceMonth) || 0;
            const pricePerYear = parseFloat(form.closest('.booking-card').dataset.priceYear) || 0;
            const bookingDate = document.getElementById('booking_date');
            const durationEl = document.getElementById('duration');
            const durationUnit = document.getElementById('duration_unit');
            const guests = document.getElementById('total_guests');
            const durationSummary = document.getElementById('durationSummary');
            const totalPriceEl = document.getElementById('totalPrice');

            // Set minimum selectable date
            const today = new Date();
            const isoToday = today.toISOString().split('T')[0];
            if (bookingDate) bookingDate.setAttribute('min', isoToday);

            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID').format(value);
            }

            function updateSummary() {
                const duration = parseInt(durationEl.value || 0, 10);
                const unit = durationUnit.value;

                if (!duration || duration < 1) {
                    durationSummary.textContent = '-';
                    totalPriceEl.textContent = 'Rp -';
                    return false;
                }

                let unitPrice = 0;
                if (unit === 'month') unitPrice = pricePerMonth;
                if (unit === 'year') unitPrice = pricePerYear;

                if (!unitPrice || unitPrice <= 0) {
                    // price not set for chosen unit
                    durationSummary.textContent = duration + ' ' + (unit === 'month' ? 'bulan' : 'tahun') + ' (harga belum diset)';
                    totalPriceEl.textContent = 'Rp -';
                    return false;
                }

                const total = Math.max(0, duration * unitPrice);
                durationSummary.textContent = duration + ' ' + (unit === 'month' ? 'bulan' : 'tahun');
                totalPriceEl.textContent = 'Rp ' + formatRupiah(total);
                return true;
            }

            [bookingDate, durationEl, durationUnit, guests].forEach(el => el && el.addEventListener('change', updateSummary));

            form.addEventListener('submit', function (e) {
                const valid = updateSummary();
                if (!valid) {
                    e.preventDefault();
                    alert('Durasi tidak valid atau harga belum diset untuk unit yang dipilih.');
                    return false;
                }
                return true;
            });

            // Tabs: make clicks smooth and set active state
            const tabs = document.querySelectorAll('.detail-tabs .tab-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    const target = document.querySelector(tab.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // Sticky behavior disabled: sidebar will remain in normal flow so items don't follow to footer.
            // No JS required — the aside stays static and scrolls naturally with page content.

            // Rating stars: interactive hover/click and keyboard support
            (function() {
                const starPicker = document.querySelector('.star-picker');
                if (!starPicker) return;

                starPicker.setAttribute('role', 'radiogroup');
                starPicker.setAttribute('aria-label', 'Pilih rating');

                const stars = Array.from(starPicker.querySelectorAll('.rating-star.star-toggle'));
                const ratingInput = document.getElementById('reviewRating');
                let selected = parseInt(ratingInput && ratingInput.value ? ratingInput.value : 0, 10) || 0;

                function paint(v) {
                    stars.forEach(s => {
                        const val = parseInt(s.dataset.value, 10);
                        if (val <= v) {
                            s.classList.add('active');
                            s.style.opacity = '1';
                        } else {
                            s.classList.remove('active');
                            s.style.opacity = '0.55';
                        }
                        s.setAttribute('aria-checked', val <= selected ? 'true' : 'false');
                    });
                }

                stars.forEach(s => {
                    s.setAttribute('tabindex', '0');
                    s.setAttribute('role', 'radio');

                    s.addEventListener('mouseenter', () => paint(parseInt(s.dataset.value, 10)));
                    s.addEventListener('mouseleave', () => paint(selected));

                    s.addEventListener('click', () => {
                        selected = parseInt(s.dataset.value, 10);
                        if (ratingInput) ratingInput.value = selected;
                        paint(selected);
                    });

                    s.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            s.click();
                            return;
                        }
                        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                            e.preventDefault();
                            if (e.key === 'ArrowLeft') selected = Math.max(1, selected - 1 || 1);
                            if (e.key === 'ArrowRight') selected = Math.min(5, (selected || 0) + 1);
                            if (ratingInput) ratingInput.value = selected;
                            paint(selected);
                        }
                    });
                });

                // initialize visual state
                paint(selected);
            })();

            // initialize
            updateSummary();
        });
    </script>
@endsection