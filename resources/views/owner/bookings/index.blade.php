@extends('layouts.app')

@section('title', 'Pemesanan Saya')

@section('content')
    <div class="owner-bookings-list">
        <div class="container">
            <div class="header">
                <h1>Pemesanan untuk Kamar Saya</h1>
                <p class="text-muted">Kelola pemesanan yang masuk untuk kamar Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->user->name }}<br><small class="text-muted">{{ $booking->user->email }}</small>
                                </td>
                                <td>{{ $booking->homestay->title ?? $booking->homestay->name }}</td>
                                <td>{{ $booking->check_in_date }}</td>
                                <td>{{ $booking->check_out_date }}</td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="text-capitalize">{{ $booking->status }}</td>
                                <td>
                                    <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                                Menunggu</option>
                                            <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Dibayar
                                                (menunggu konfirmasi)</option>
                                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                                Konfirmasi</option>
                                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                                Selesai</option>
                                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                                Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada pemesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection