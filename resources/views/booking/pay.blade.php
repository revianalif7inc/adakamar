@extends('layouts.app')

@section('css')
    <style>
        .pay-page { padding: 36px 0; }
        .pay-card { max-width: 920px; margin: 0 auto; border-radius: 12px; box-shadow: 0 8px 30px rgba(28,40,60,0.08); overflow: hidden; }
        .pay-grid { display: flex; gap: 22px; align-items: flex-start; padding: 24px; }
        .pay-image { width: 260px; flex-shrink: 0; }
        .pay-image img { width: 100%; height: 160px; object-fit: cover; border-radius: 8px; }
        .pay-details { flex: 1; }
        .pay-title { font-size: 1.4rem; font-weight: 800; color: #1e3a5f; margin-bottom: 6px; }
        .meta-row { display: flex; gap: 18px; flex-wrap: wrap; color: #555; font-size: 0.95rem; }
        .meta-item { min-width: 160px; }
        .payment-summary { background: #fbfbfb; border: 1px solid #eee; padding: 14px; border-radius: 8px; margin-top: 12px; }
        .payment-summary .row { align-items: center; }
        .summary-label { color: #666; }
        .summary-amount { text-align: right; font-weight: 800; color: #1e3a5f; }
        .btn-primary-pay { background: #1e3a5f; border: 0; padding: 12px 18px; font-weight: 700; box-shadow: 0 6px 18px rgba(30,58,95,0.12); }
        .btn-secondary-pay { background: transparent; border: 1px solid #ddd; color: #333; padding: 10px 14px; }
        .pay-actions { margin-top: 14px; display: flex; gap: 10px; }
        @media (max-width: 768px) {
            .pay-grid { flex-direction: column; padding: 16px; }
            .pay-image { width: 100%; }
            .pay-image img { height: 180px; }
            .pay-actions { flex-direction: column; }
            .btn-primary-pay { width: 100%; }
        }
    </style>
@endsection

@section('content')
    <div class="container pay-page">
        <div class="pay-card bg-white">
            <div class="pay-grid">
                <div class="pay-image">
                    @if(!empty($booking->homestay) && !empty($booking->homestay->image))
                        <img src="{{ asset('storage/' . $booking->homestay->image) }}" alt="{{ $booking->homestay->name ?? 'Homestay' }}">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" alt="no-image">
                    @endif
                </div>

                <div class="pay-details">
                    <div class="pay-title">{{ $booking->homestay->name ?? ($booking->homestay->title ?? 'Homestay') }}</div>

                    <div class="meta-row">
                        <div class="meta-item"><strong>Check In:</strong> {{ optional($booking->check_in_date)->format('d M Y') ?? $booking->check_in_date }}</div>
                        <div class="meta-item"><strong>Check Out:</strong> {{ optional($booking->check_out_date)->format('d M Y') ?? $booking->check_out_date }}</div>
                        <div class="meta-item"><strong>Jumlah Tamu:</strong> {{ $booking->total_guests ?? 1 }}</div>
                    </div>

                    <div class="payment-summary">
                        <div class="row">
                            <div class="col-8 summary-label">Subtotal Pemesanan</div>
                            <div class="col-4 summary-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-8 summary-label">Diskon / Promo</div>
                            <div class="col-4 summary-amount">Rp 0</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-8 summary-label">Biaya Admin</div>
                            <div class="col-4 summary-amount">Rp 0</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-8 summary-label">Pajak (PPN 10%)</div>
                            <div class="col-4 summary-amount">Rp 0</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-8 summary-label"><strong>Total Yang Harus Dibayar</strong></div>
                            <div class="col-4 summary-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <form action="{{ route('booking.pay', $booking->slug) }}" method="POST">
                        @csrf
                        <div class="pay-actions">
                            <button class="btn btn-primary btn-primary-pay" type="submit">Konfirmasi Pembayaran</button>
                            <a href="{{ route('booking.my_rooms') }}" class="btn btn-secondary btn-secondary-pay">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection