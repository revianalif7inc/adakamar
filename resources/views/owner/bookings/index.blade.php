@extends('layouts.app')

@section('title', 'Pemesanan Saya')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bookings.css') }}">
@endsection

@section('content')
    <div class="admin-bookings-list">
        <div class="container">
            <!-- Header -->
            <div class="admin-bookings-header">
                <div>
                    <h1><i class="fas fa-list-check"></i> Pemesanan Kamar Saya</h1>
                    <p class="text-muted">Kelola dan konfirmasi pemesanan yang masuk untuk kamar Anda</p>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            <!-- Bookings Table -->
            <div class="bookings-list-card">
                <div class="table-responsive-wrapper">
                    <table class="table table-bookings">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Pemesan</th>
                                <th>Kontak</th>
                                <th>Kamar</th>
                                <th width="100">Check-In</th>
                                <th width="100">Check-Out</th>
                                <th width="130">Total Harga</th>
                                <th width="110">Status</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td><strong>#{{ $booking->id }}</strong></td>
                                    <td>
                                        <div class="user-info">
                                            <p class="user-name">{{ $booking->nama ?? $booking->user->name }}</p>
                                            <p class="user-email">{{ $booking->user->email }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <p>{{ $booking->email ?? '—' }}</p>
                                            <p><a href="tel:{{ $booking->nomor_hp }}">{{ $booking->nomor_hp ?? '—' }}</a></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="homestay-info">
                                            <p class="homestay-name">{{ $booking->homestay->name }}</p>
                                            <p class="homestay-location">📍 {{ $booking->homestay->location }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-badge">{{ $booking->check_in_date->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="date-badge">{{ $booking->check_out_date->format('d M Y') }}</span>
                                    </td>
                                    <td><strong class="price-text">Rp
                                            {{ number_format(max(0, $booking->total_price), 0, ',', '.') }}</strong></td>
                                    <td>
                                        <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST"
                                            class="status-form">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="status-select" onchange="this.form.submit()">
                                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                                    Menunggu</option>
                                                <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Dibayar
                                                    (menunggu konfirmasi)</option>
                                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('booking.show', $booking->slug) }}" class="btn btn-xs btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center empty-state">
                                        <i class="fas fa-calendar empty-icon"></i>
                                        <p class="text-muted">Tidak ada pemesanan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>

@endsection