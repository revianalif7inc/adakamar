@extends('layouts.app')

@section('title', 'Pesan Homestay')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')
    <button type="submit" class="btn btn-primary btn-large">
        <i class="fa fa-arrow-right"></i> Lanjutkan Ke Pembayaran
    </button>
    <div class="booking-container">
        <div class="container">
            <h1>🏠 Pesan {{ $homestay->name }}</h1>

            <div class="booking-form-wrapper" data-price-month="{{ $homestay->price_per_month ?? '' }}"
                data-price-year="{{ $homestay->price_per_year ?? '' }}"
                data-price-night="{{ $homestay->price_per_night ?? '' }}">
                <div class="homestay-info">
                    @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                        <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}">
                    @else
                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                    @endif
                    <h3>{{ $homestay->name }}</h3>
                    <p>{{ $homestay->location }}</p>
                    @if($homestay->price_per_month)
                        <p class="price">Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan</p>
                    @elseif($homestay->price_per_year)
                        <p class="price">Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun</p>
                    @elseif($homestay->price_per_night)
                        <p class="price">Rp {{ number_format($homestay->price_per_night, 0, ',', '.') }} / malam</p>
                    @else
                        <p class="price text-muted">Harga belum tersedia</p>
                    @endif
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="booking-form">
                    @csrf
                    <input type="hidden" name="homestay_id" value="{{ $homestay->id }}">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="booking_date">📅 Tanggal Pemesanan</label>
                        <input type="date" id="booking_date" name="booking_date"
                            value="{{ request()->query('booking_date') ?? old('booking_date') }}" required>
                        <small class="form-text text-muted">Cukup pilih tanggal pemesanan. Durasi dan harga akan ditentukan
                            oleh pemilik nanti.</small>
                    </div>

                    <div class="form-group">
                        <label for="duration">⏱️ Durasi</label>
                        <div class="duration-row">
                            <input type="number" id="duration" name="duration" min="1"
                                value="{{ request()->query('duration') ?? old('duration', 1) }}"
                                class="form-control duration-input" required>
                            <select id="duration_unit" name="duration_unit" class="form-control duration-unit">
                                <option value="month" {{ (request()->query('duration_unit') ?? old('duration_unit')) === 'month' ? 'selected' : '' }}>Bulan</option>
                                <option value="year" {{ (request()->query('duration_unit') ?? old('duration_unit')) === 'year' ? 'selected' : '' }}>Tahun</option>
                                <option value="night" {{ (request()->query('duration_unit') ?? old('duration_unit')) === 'night' ? 'selected' : '' }}>Harian</option>
                            </select>
                        </div>
                        <small class="form-text text-muted">Pilih durasi pemesanan (mis. 1 bulan, 12 bulan, atau 1
                            tahun).</small>
                    </div>

                    <div class="form-group">
                        <label for="total_guests">👥 Jumlah Tamu</label>
                        <input type="number" id="total_guests" name="total_guests" min="1" max="{{ $homestay->max_guests }}"
                            value="{{ request()->query('total_guests') ?? old('total_guests', 1) }}" required>
                        <small>Kapasitas maksimal: {{ $homestay->max_guests }} tamu</small>
                    </div>

                    <div class="form-group">
                        <label for="special_requests">💬 Catatan (Optional)</label>
                        <textarea id="special_requests" name="special_requests" rows="4"
                            placeholder="Tulis permintaan khusus Anda...">{{ old('special_requests') }}</textarea>
                    </div>

                    <hr style="margin: 30px 0;">
                    <h3>📝 Data Diri Pemesan</h3>

                    <div class="form-group">
                        <label for="nama">👤 Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', auth()->user()->name ?? '') }}"
                            required placeholder="Masukkan nama lengkap Anda">
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">✉️ Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                            required placeholder="Masukkan email Anda">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nomor_hp">📱 Nomor Handphone</label>
                        <input type="tel" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required
                            placeholder="Contoh: 0812-3456-7890">
                        @error('nomor_hp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="price-summary">
                        <p>💰 Harga: <strong id="total">–</strong></p>
                        <small class="form-text text-muted">Harga akan dihitung saat pemilik mengonfirmasi atau berdasarkan
                            durasi pemesanan.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large">Lanjutkan Ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/booking-form.js') }}"></script>
@endsection