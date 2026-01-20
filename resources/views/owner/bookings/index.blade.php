@extends('layouts.app')

@section('title', 'Pemesanan Saya')

@section('content')
    <div class="owner-bookings-list">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Pemesanan Kamar Saya</h1>
                    <p class="text-muted">Kelola dan konfirmasi pemesanan yang masuk untuk kamar Anda</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="bookings-table-wrapper">
                <table class="table table-admin table-striped">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th width="100">Check In</th>
                            <th width="100">Check Out</th>
                            <th width="120">Total</th>
                            <th width="110">Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td><strong>#{{ $booking->id }}</strong></td>
                                <td>
                                    <div class="user-info">
                                        <p class="user-name">{{ $booking->user->name }}</p>
                                        <p class="user-email" style="font-size: 0.85rem;">{{ $booking->user->email }}</p>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $booking->homestay->name ?? $booking->homestay->title }}</strong>
                                </td>
                                <td><span class="date-badge">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</span></td>
                                <td><span class="date-badge">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span></td>
                                <td>
                                    <strong class="price-text">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($booking->status === 'pending')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-hourglass-half"></i> Menunggu
                                        </span>
                                    @elseif($booking->status === 'paid')
                                        <span class="badge badge-info">
                                            <i class="fas fa-money-bill"></i> Dibayar
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Dikonfirmasi
                                        </span>
                                    @elseif($booking->status === 'completed')
                                        <span class="badge badge-success">
                                            <i class="fas fa-flag-checkered"></i> Selesai
                                        </span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle"></i> Dibatalkan
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button type="submit" class="btn btn-warning btn-sm" title="Tandai Sudah Dibayar" onclick="return confirm('Tandai pembayaran diterima?')">
                                                    <i class="fas fa-credit-card"></i> Bayar
                                                </button>
                                            </form>
                                        @elseif($booking->status === 'paid')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-success btn-sm" title="Konfirmasi Booking" onclick="return confirm('Konfirmasi pemesanan ini?')">
                                                    <i class="fas fa-check"></i> Konfirmasi
                                                </button>
                                            </form>
                                        @elseif($booking->status === 'confirmed')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-info btn-sm" title="Tandai Selesai" onclick="return confirm('Tandai pemesanan selesai?')">
                                                    <i class="fas fa-flag-checkered"></i> Selesai
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($booking->status !== 'completed' && $booking->status !== 'cancelled')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Batalkan" onclick="return confirm('Batalkan pemesanan ini?')">
                                                    <i class="fas fa-ban"></i> Batal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <p class="text-muted"><i class="fas fa-inbox" style="font-size: 2rem;"></i></p>
                                    <p class="text-muted mt-2">Tidak ada pemesanan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>

            <div class="mt-5 p-4 bg-light rounded">
                <h5><i class="fas fa-info-circle"></i> Alur Status Pemesanan</h5>
                <div class="row mt-3">
                    <div class="col-md-3 text-center">
                        <span class="badge badge-warning" style="padding: 10px; font-size: 0.9rem;">Menunggu</span>
                        <p class="text-muted mt-2" style="font-size: 0.9rem;">Customer menunggu konfirmasi</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-arrow-right text-muted"></i>
                        <span class="badge badge-info" style="padding: 10px; font-size: 0.9rem;">Dibayar</span>
                        <p class="text-muted mt-2" style="font-size: 0.9rem;">Pembayaran diterima</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-arrow-right text-muted"></i>
                        <span class="badge badge-success" style="padding: 10px; font-size: 0.9rem;">Dikonfirmasi</span>
                        <p class="text-muted mt-2" style="font-size: 0.9rem;">Booking dikonfirmasi</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="fas fa-arrow-right text-muted"></i>
                        <span class="badge badge-success" style="padding: 10px; font-size: 0.9rem;">Selesai</span>
                        <p class="text-muted mt-2" style="font-size: 0.9rem;">Check-out selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection