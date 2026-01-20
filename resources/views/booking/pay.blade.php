@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2>Bayar Booking</h2>

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $booking->homestay->title ?? 'Homestay' }}</h5>
                <p class="mb-1"><strong>Check In:</strong> {{ $booking->check_in_date }}</p>
                <p class="mb-1"><strong>Check Out:</strong> {{ $booking->check_out_date }}</p>
                <p class="mb-1"><strong>Total:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

                <form action="{{ route('booking.pay', $booking->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary mt-3">Konfirmasi Pembayaran (placeholder)</button>
                    <a href="{{ route('booking.my_rooms') }}" class="btn btn-secondary mt-3 ms-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection