@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Kamar Saya</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @if($bookings->count())

        
            <div class="my-rooms-grid">
                @foreach($bookings as $booking)
                    @php
                        $hs = $booking->homestay;
                        $img = $hs->image_url ?? null;
                        $checkIn = $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date) : null;
                        $checkOut = $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date) : null;
                        $duration = ($checkIn && $checkOut) ? $checkIn->diffInDays($checkOut) : null;
                    @endphp

                    <div class="booking-card my-booking-card">
                        <div class="booking-thumb">
                            @if(!empty($img) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $hs->name ?? $hs->title ?? 'Homestay' }}">
                            @else
                                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                            @endif
                        </div>

                        <div class="booking-body">
                            <div class="booking-head">
                                <h3 class="booking-title">{{ $hs->name ?? $hs->title ?? '—' }}</h3>
                                <p class="muted booking-loc">{{ $hs->location ?? '' }}</p>
                            </div>

                            <div class="booking-meta">
                                <div class="meta-item"><strong>Check-in</strong><span>{{ $checkIn ? $checkIn->format('d M Y') : '—' }}</span></div>
                                <div class="meta-item"><strong>Check-out</strong><span>{{ $checkOut ? $checkOut->format('d M Y') : '—' }}</span></div>
                                <div class="meta-item"><strong>Durasi</strong><span>{{ $duration ? $duration . ' hari' : '—' }}</span></div>
                            </div>

                            <div class="booking-footer">
                                <div class="price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                <div class="status">
                                    @if($booking->status === 'pending')
                                        <span class="badge badge-warning">Menunggu Pembayaran</span>
                                    @elseif($booking->status === 'paid')
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge badge-info">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="booking-actions mt-2">
                                <a href="{{ route('booking.confirmation', $booking->id) }}" class="btn btn-sm btn-outline"><i class="fa fa-info-circle" aria-hidden="true"></i> Detail</a>

                                @if($booking->status === 'pending')
                                    <a href="{{ route('booking.pay.form', $booking->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-credit-card" aria-hidden="true"></i> Bayar</a>
                                @endif

                                @if($booking->status === 'paid')
                                    <a href="{{ route('booking.confirmation', $booking->id) }}" class="btn btn-sm btn-ghost"><i class="fa fa-receipt" aria-hidden="true"></i> Bukti</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">{{ $bookings->links() }}</div>
        @else
            <div class="empty-state">
                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="empty" />
                <p class="text-muted">Anda belum melakukan booking apapun.</p>
                <a href="{{ route('homestays.index') }}" class="btn btn-primary"><i class="fa fa-search"></i> Telusuri Homestay</a>
            </div>
        @endif
    </div>
@endsection