@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
    <div class="confirmation-container">
        <div class="container">
            <div class="confirmation-box confirmation-page">
                <div class="confirmation-hero">
                    <div class="hero-icon">✓</div>
                    <div class="hero-text">
                        <h1>Pemesanan Berhasil</h1>
                        <p class="muted">Terima kasih — pesanan Anda telah diterima. Nomor pesanan
                            <strong>#{{ $booking->id }}</strong></p>
                    </div>
                    <div class="hero-status">
                        <span class="badge badge-status">{{ ucfirst($booking->status) }}</span>
                    </div>
                </div>

                <div class="confirmation-grid">
                    <div class="confirmation-card summary">
                        @php
                            $img = $booking->homestay->image_url ?? null;
                        @endphp
                        <div class="summary-head">
                            <div class="thumb">
                                @if(!empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $booking->homestay->name }}">
                                @else
                                    <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                @endif
                            </div>
                            <div class="summary-title">
                                <h3>{{ $booking->homestay->name }}</h3>
                                <p class="muted">{{ $booking->homestay->location }}</p>
                            </div>
                        </div>

                        <div class="summary-meta">
                            <p><strong>Check-In:</strong> {{ optional($booking->check_in_date)->format('d M Y') }}</p>
                            @if($booking->check_out_date)
                                <p><strong>Check-Out:</strong> {{ optional($booking->check_out_date)->format('d M Y') }}</p>
                                @php
                                    try {
                                        $days = $booking->check_out_date->diffInDays($booking->check_in_date);
                                    } catch (\Exception $e) {
                                        $days = null;
                                    }
                                @endphp
                                @if($days)
                                    <p><strong>Durasi:</strong> {{ $days }} hari</p>
                                @endif
                            @else
                                <p><em>Durasi akan ditentukan pemilik</em></p>
                            @endif

                            <p><strong>Jumlah Tamu:</strong> {{ $booking->total_guests }} orang</p>

                            @if($booking->special_requests)
                                <p><strong>Permintaan:</strong> {{ $booking->special_requests }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="confirmation-card details">
                        <h3>Rincian Pembayaran</h3>

                        <ul class="booking-breakdown">
                            <li><span>Subtotal</span><span>Rp
                                    {{ number_format(max(0, $booking->total_price), 0, ',', '.') }}</span></li>
                            <li><span>Diskon</span><span>Rp 0</span></li>
                            <li class="total"><strong>Total</strong><strong>Rp
                                    {{ number_format(max(0, $booking->total_price), 0, ',', '.') }}</strong></li>
                        </ul>

                        <hr style="margin: 20px 0;">
                        <h3>📝 Data Diri Pemesan</h3>
                        <ul class="booking-details-list" style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 12px;"><strong>Nama:</strong> {{ $booking->nama }}</li>
                            <li style="margin-bottom: 12px;"><strong>Email:</strong> <a
                                    href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></li>
                            <li style="margin-bottom: 12px;"><strong>Nomor HP:</strong> <a
                                    href="tel:{{ $booking->nomor_hp }}">{{ $booking->nomor_hp }}</a></li>
                        </ul>

                        <div class="confirm-actions">
                            <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print btn-icon"
                                    aria-hidden="true"></i> Cetak Bukti</button>

                            @if(!empty($booking->homestay->owner->phone))
                                <a href="tel:{{ $booking->homestay->owner->phone }}" class="btn btn-secondary"><i
                                        class="fa fa-phone btn-icon" aria-hidden="true"></i> Hubungi Pemilik</a>
                            @endif

                            <a href="{{ url('bookings/' . $booking->id) }}" class="btn btn-outline"><i
                                    class="fa fa-file-alt btn-icon" aria-hidden="true"></i> Lihat Detail Pemesanan</a>
                        </div>

                        <div class="small muted mt-3">Jika Anda belum melakukan pembayaran, silakan tunggu instruksi dari
                            pemilik.</div>
                    </div>
                </div>

                <div class="next-steps">
                    <h4>Langkah Selanjutnya</h4>
                    <ol>
                        <li>Tunggu konfirmasi dari pemilik homestay</li>
                        <li>Ikuti instruksi pembayaran yang dikirim via email atau pesan</li>
                        <li>Tunjukkan bukti pembayaran saat check-in</li>
                    </ol>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('home') }}" class="btn btn-ghost"><i class="fa fa-home btn-icon"
                            aria-hidden="true"></i> Kembali ke Beranda</a>
                    <a href="{{ route('homestays.index') }}" class="btn btn-outline"><i class="fa fa-search btn-icon"
                            aria-hidden="true"></i> Lihat Homestay Lainnya</a>
                </div>
            </div>
        </div>
    </div>
@endsection