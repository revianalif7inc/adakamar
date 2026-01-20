@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1>Dashboard Owner</h1>
                    <p class="text-muted">Kelola kamar Anda dan lihat pemesanan terbaru</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kamar Baru
                    </a>
                </div>
            </div>

            <div class="dashboard-stats">
                <div class="stat-card stat-card-kamar">
                    <div class="stat-icon"><i class="fas fa-home"></i></div>
                    <div class="stat-content">
                        <h3>Total Kamar</h3>
                        <p class="stat-number">{{ $totalHomestays }}</p>
                    </div>
                </div>

                <div class="stat-card stat-card-booking">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-content">
                        <h3>Total Pemesanan</h3>
                        <p class="stat-number">{{ $totalBookings }}</p>
                    </div>
                </div>

                <div class="stat-card stat-card-pending">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-content">
                        <h3>Pemesanan Menunggu</h3>
                        <p class="stat-number">{{ $pendingBookings }}</p>
                    </div>
                </div>

                <div class="stat-card stat-card-revenue">
                    <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="stat-content">
                        <h3>Total Pendapatan</h3>
                        <p class="stat-number">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-header">
                    <h2><i class="fas fa-home"></i> Kamar Saya</h2>
                    <div class="section-actions">
                        <a href="{{ route('owner.kamar.index') }}" class="btn btn-secondary btn-sm"><i
                                class="fas fa-list"></i> Lihat Semua</a>
                        <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus"></i> Baru</a>
                    </div>
                </div>

                <div class="section-body">
                    @if(isset($myHomestays) && $myHomestays->count())
                        <div class="mini-homestay-grid">
                            @foreach($myHomestays as $h)
                                <div class="mini-homestay-card">
                                    @if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url))
                                        <img src="{{ asset('storage/' . $h->image_url) }}" alt="{{ $h->name }}">
                                    @else
                                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                    @endif
                                    <div class="mini-homestay-body">
                                        <p class="mini-name">{{ \Illuminate\Support\Str::limit($h->name, 40) }}</p>
                                        <a href="{{ route('owner.kamar.edit', $h->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada kamar yang Anda tambahkan</p>
                    @endif
                </div>
            </div>

            <div class="admin-section">
                <div class="section-header">
                    <h2><i class="fas fa-list-check"></i> Pemesanan Terbaru</h2>
                    <div class="section-actions">
                        <a href="{{ route('owner.kamar.index') }}" class="btn btn-secondary btn-sm"><i
                                class="fas fa-list"></i> Lihat Kamar Saya</a>
                    </div>
                </div>

                <div class="bookings-table-wrapper">
                    <table class="table table-admin">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Tamu</th>
                                <th>Kamar</th>
                                <th>Check-In</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td><strong>#{{ $booking->id }}</strong></td>
                                    <td>
                                        <div class="user-info">
                                            <p class="user-name">{{ $booking->user->name }}</p>
                                            <p class="user-email">{{ $booking->user->email }}</p>
                                        </div>
                                    </td>
                                    <td>{{ $booking->homestay->name }}</td>
                                    <td><span class="date-badge">{{ $booking->check_in_date->format('d M Y') }}</span></td>
                                    <td><strong class="price-text">Rp
                                            {{ number_format(max(0, $booking->total_price), 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="badge badge-info">Dikonfirmasi</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted"><i class="fas fa-inbox"></i> Tidak ada pemesanan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection