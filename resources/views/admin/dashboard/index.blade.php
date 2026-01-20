@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <div class="admin-dashboard">
        <div class="container">
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1>Dashboard Admin</h1>
                    <p class="text-muted">Kelola semua aspek platform AdaKamar dari sini</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.kamar.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kamar Baru
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="dashboard-stats">
                <div class="stat-card stat-card-kamar">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Kamar</h3>
                        <p class="stat-number">{{ $totalHomestays }}</p>
                    </div>
                </div>
                <div class="stat-card stat-card-booking">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Pemesanan</h3>
                        <p class="stat-number">{{ $totalBookings }}</p>
                    </div>
                </div>
                <div class="stat-card stat-card-pending">
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Pemesanan Menunggu</h3>
                        <p class="stat-number">{{ $pendingBookings }}</p>
                    </div>
                </div>
                <div class="stat-card stat-card-revenue">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Pendapatan</h3>
                        <p class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Management Sections -->
            <div class="admin-sections">
                <!-- Small quick-manage cards for categories & locations -->
                <div class="quick-manage-grid">
                    <div class="quick-card">
                        <div class="quick-card-row">
                            <div>
                                <h4 class="quick-card-title">Kategori</h4>
                                <p class="quick-card-number">{{ $totalCategories ?? 0 }}</p>
                            </div>
                            <div class="quick-card-actions">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">Lihat</a>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Baru</a>
                            </div>
                        </div>
                    </div>

                    <div class="quick-card">
                        <div class="quick-card-row">
                            <div>
                                <h4 class="quick-card-title">Lokasi</h4>
                                <p class="quick-card-number">{{ $totalLocations ?? 0 }}</p>
                            </div>
                            <div class="quick-card-actions">
                                <a href="{{ route('admin.locations.index') }}" class="btn btn-sm btn-secondary">Lihat</a>
                                <a href="{{ route('admin.locations.create') }}" class="btn btn-sm btn-primary">Baru</a>
                            </div>
                        </div>
                    </div>

                    <div class="quick-card">
                        <div class="quick-card-row">
                            <div>
                                <h4 class="quick-card-title">Pengguna</h4>
                                <p class="quick-card-number">{{ \App\Models\User::count() ?? 0 }}</p>
                            </div>
                            <div class="quick-card-actions">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Lihat</a>
                            </div>
                        </div>
                    </div>

                    <div class="quick-card">
                        <div class="quick-card-row">
                            <div>
                                <h4 class="quick-card-title">Artikel</h4>
                                <p class="quick-card-number">{{ \App\Models\Article::count() ?? 0 }}</p>
                            </div>
                            <div class="quick-card-actions">
                                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-secondary">Lihat</a>
                                <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary">Baru</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent categories & locations -->
                <div class="admin-section section-no-padding">
                    <div class="section-header">
                        <h2><i class="fas fa-tags"></i> Kategori & Lokasi</h2>
                        <div class="section-actions">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-list"></i> Semua Kategori</a>
                            <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-list"></i> Semua Lokasi</a>
                        </div>
                    </div>
                    <div class="section-body recent-wrap">
                        <div class="recent-column">
                            <h5 class="recent-title">Kategori Terbaru</h5>
                            <ul class="list-unstyled">
                                @forelse($recentCategories as $cat)
                                    <li class="recent-item">
                                        <div>
                                            <strong>{{ $cat->name }}</strong>
                                            <div class="recent-desc">{{ \Illuminate\Support\Str::limit($cat->description, 80) }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.categories.edit', $cat) }}"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">Belum ada kategori</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="recent-column">
                            <h5 class="recent-title">Lokasi Terbaru</h5>
                            <ul class="list-unstyled">
                                @forelse($recentLocations as $loc)
                                    <li class="recent-item">
                                        <div>
                                            <strong>{{ $loc->name }}</strong>
                                            <div class="recent-desc">{{ \Illuminate\Support\Str::limit($loc->description, 80) }}</div>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.locations.edit', $loc) }}"
                                                class="btn btn-sm btn-secondary">Edit</a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">Belum ada lokasi</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Kamar Management Section -->
                <div class="admin-section section-no-padding">
                    <div class="section-header">
                        <h2><i class="fas fa-door-open"></i> Manajemen Kamar</h2>
                        <div class="section-actions">
                            <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-list"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="section-body">

                        @if(isset($recentHomestays) && $recentHomestays->count())
                            <div class="mini-homestay-section">
                                <h5 class="recent-title">Kamar Terbaru</h5>
                                <div class="mini-homestay-grid">
                                    @foreach($recentHomestays as $h)
                                        <div class="mini-homestay-card">
                                            @if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url))
                                                <img src="{{ asset('storage/' . $h->image_url) }}" alt="{{ $h->name }}">
                                            @else
                                                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                                            @endif
                                            <div class="mini-homestay-body">
                                                <p class="mini-name">{{ \Illuminate\Support\Str::limit($h->name, 40) }}</p>
                                                <p class="mini-owner">{{ $h->owner->name ?? '—' }}</p>
                                                <small class="mini-status">@if($h->is_active)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-warning">Nonaktif</span>@endif</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users Section (moved out of Kamar Management) -->
                <div class="admin-section section-no-padding">
                    <div class="section-header">
                        <h2><i class="fas fa-users"></i> Pengguna Terbaru</h2>
                        <div class="section-actions">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Lihat Semua Pengguna</a>
                        </div>
                    </div>

                    <div class="section-body">
                        <div class="user-grid">
                            @foreach($recentUsers as $u)
                                <div class="user-card">
                                    <div class="user-card-left">
                                        <div class="user-avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                        <div class="user-body">
                                            <p class="user-name">{{ $u->name }} <small class="text-muted">• {{ $u->created_at->format('d M Y') }}</small></p>
                                            <p class="user-email">{{ $u->email }}</p>
                                            <div class="user-meta">
                                                <small class="text-muted">Role: {{ ucfirst($u->role) }}</small>
                                                <small class="text-muted ms-2">Ulasan: <strong>{{ $u->reviews_count ?? 0 }}</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-actions">
                                        <a href="{{ route('admin.reviews.index', ['user_id' => $u->id]) }}" class="btn btn-sm btn-warning">Lihat Ulasan</a>
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- Bookings Section -->
                <div class="admin-section section-no-padding">
                    <div class="section-header">
                        <h2><i class="fas fa-list-check"></i> Pemesanan Terbaru</h2>
                        <div class="section-actions">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                        <div class="section-body">
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
                                        <th width="100">Aksi</th>
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
                                            <td>
                                                <span class="date-badge">{{ $booking->check_in_date->format('d M Y') }}</span>
                                            </td>
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
                                            <td>
                                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-xs btn-info"
                                                    title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <p class="text-muted"><i class="fas fa-inbox"></i> Tidak ada pemesanan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <!-- Ratings Section (moved below Bookings) -->
            <div class="admin-section section-no-padding">
                <div class="section-header">
                    <h2><i class="fas fa-star"></i> Ulasan & Rating</h2>
                    <div class="section-actions">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">Kelola Ulasan</a>
                    </div>
                </div>

                <div class="section-body">
                    @if(isset($recentReviews) && $recentReviews->count())
                        <ul class="list-unstyled">
                            @foreach($recentReviews as $r)
                                <li class="recent-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $r->user->name }} </strong> • <small class="text-muted">{{ $r->user->email }}</small>
                                        <div>{{ $r->homestay->name ?? '-' }} • <span class="badge-rating">★ {{ number_format($r->rating,1) }}</span></div>
                                        <div class="recent-desc">{{ \Illuminate\Support\Str::limit($r->comment, 120) }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.reviews.edit', $r->id) }}" class="btn btn-sm btn-info">Sunting</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada ulasan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    
@endsection