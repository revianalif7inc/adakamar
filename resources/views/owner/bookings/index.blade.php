@extends('layouts.app')

@section('title', 'Pemesanan Saya')

@section('content')
    <div class="owner-bookings-list" style="padding: 40px 0;">
        <div class="container">
            <!-- Header Section -->
            <div class="admin-header mb-4" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 25px;">
                <div>
                    <h1 style="margin-bottom: 5px; font-weight: 700; color: #2c3e50;">
                        <i class="fas fa-list-check" style="color: #3498db; margin-right: 10px;"></i>Pemesanan Kamar Saya
                    </h1>
                    <p class="text-muted" style="font-size: 0.95rem;">Kelola dan konfirmasi pemesanan yang masuk untuk kamar Anda</p>
                </div>
                <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary" style="white-space: nowrap;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; border-left: 4px solid #28a745;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; border-left: 4px solid #dc3545;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Stats Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #f39c12; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <p style="margin: 0; font-size: 0.9rem; color: #7f8c8d; font-weight: 600;">Total Pemesanan</p>
                    <p style="margin: 5px 0 0 0; font-size: 1.8rem; font-weight: 700; color: #f39c12;">{{ $bookings->total() }}</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #e67e22; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <p style="margin: 0; font-size: 0.9rem; color: #7f8c8d; font-weight: 600;">Menunggu Konfirmasi</p>
                    <p style="margin: 5px 0 0 0; font-size: 1.8rem; font-weight: 700; color: #e67e22;">{{ $bookings->where('status', 'pending')->count() + $bookings->where('status', 'paid')->count() }}</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #27ae60; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <p style="margin: 0; font-size: 0.9rem; color: #7f8c8d; font-weight: 600;">Dikonfirmasi</p>
                    <p style="margin: 5px 0 0 0; font-size: 1.8rem; font-weight: 700; color: #27ae60;">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #2980b9; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <p style="margin: 0; font-size: 0.9rem; color: #7f8c8d; font-weight: 600;">Selesai</p>
                    <p style="margin: 5px 0 0 0; font-size: 1.8rem; font-weight: 700; color: #2980b9;">{{ $bookings->where('status', 'completed')->count() }}</p>
                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="bookings-table-wrapper" style="background: white; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden;">
                <table class="table table-admin table-hover" style="margin-bottom: 0;">
                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                        <tr>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600;" width="60">ID</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600;">Tamu</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600;">Kamar</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600; text-align: center;">Tanggal</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600; text-align: right;">Total</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600; text-align: center;">Status</th>
                            <th style="color: white; border: none; padding: 15px; font-weight: 600; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.3s ease;">
                                <td style="padding: 15px; vertical-align: middle;"><strong style="color: #3498db;">#{{ $booking->id }}</strong></td>
                                <td style="padding: 15px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 10px;">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p style="margin: 0; font-weight: 600; color: #2c3e50;">{{ $booking->user->name }}</p>
                                            <p style="margin: 3px 0 0 0; font-size: 0.85rem; color: #95a5a6;">{{ $booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 15px; vertical-align: middle;">
                                    <strong style="color: #2c3e50;">{{ $booking->homestay->name ?? $booking->homestay->title }}</strong>
                                </td>
                                <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                    <div style="font-size: 0.9rem;">
                                        <span style="display: block; color: #7f8c8d; font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }}</span>
                                        <span style="display: block; color: #95a5a6; font-size: 0.85rem;">ke</span>
                                        <span style="display: block; color: #7f8c8d; font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td style="padding: 15px; vertical-align: middle; text-align: right;">
                                    <strong style="color: #27ae60; font-size: 1.05rem;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                </td>
                                <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                    @if($booking->status === 'pending')
                                        <span style="display: inline-block; background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-hourglass-half"></i> Menunggu
                                        </span>
                                    @elseif($booking->status === 'paid')
                                        <span style="display: inline-block; background: #d1ecf1; color: #0c5460; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-money-bill"></i> Dibayar
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i> Konfirmasi
                                        </span>
                                    @elseif($booking->status === 'completed')
                                        <span style="display: inline-block; background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-flag-checkered"></i> Selesai
                                        </span>
                                    @elseif($booking->status === 'cancelled')
                                        <span style="display: inline-block; background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-times-circle"></i> Batal
                                        </span>
                                    @else
                                        <span style="display: inline-block; background: #e2e3e5; color: #383d41; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                    <div style="display: flex; gap: 5px; justify-content: center; flex-wrap: wrap;">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button type="submit" class="btn btn-sm" style="background: #f39c12; color: white; border: none; border-radius: 5px; padding: 6px 10px; cursor: pointer; transition: background 0.3s;" title="Tandai Sudah Dibayar" onclick="return confirm('Tandai pembayaran diterima?')">
                                                    <i class="fas fa-credit-card"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->status === 'paid')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-sm" style="background: #27ae60; color: white; border: none; border-radius: 5px; padding: 6px 10px; cursor: pointer; transition: background 0.3s;" title="Konfirmasi Booking" onclick="return confirm('Konfirmasi pemesanan ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->status === 'confirmed')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm" style="background: #3498db; color: white; border: none; border-radius: 5px; padding: 6px 10px; cursor: pointer; transition: background 0.3s;" title="Tandai Selesai" onclick="return confirm('Tandai pemesanan selesai?')">
                                                    <i class="fas fa-flag-checkered"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($booking->status !== 'completed' && $booking->status !== 'cancelled')
                                            <form action="{{ route('owner.bookings.updateStatus', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-sm" style="background: #e74c3c; color: white; border: none; border-radius: 5px; padding: 6px 10px; cursor: pointer; transition: background 0.3s;" title="Batalkan" onclick="return confirm('Batalkan pemesanan ini?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 50px 15px;">
                                    <div style="text-align: center;">
                                        <i class="fas fa-inbox" style="font-size: 3rem; color: #bdc3c7; margin-bottom: 15px; display: block;"></i>
                                        <p style="margin: 0; color: #95a5a6; font-size: 1.05rem;">Tidak ada pemesanan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $bookings->links() }}
            </div>

            <!-- Info Section -->
            <div style="margin-top: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; border-radius: 8px; color: white;">
                <h5 style="margin-bottom: 20px; font-weight: 700;">
                    <i class="fas fa-question-circle"></i> Alur Status Pemesanan
                </h5>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
                    <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <span style="display: inline-block; background: #f39c12; color: white; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">
                            <i class="fas fa-hourglass-half"></i> Menunggu
                        </span>
                        <p style="margin: 10px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Customer menunggu konfirmasi pembayaran</p>
                    </div>
                    <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <span style="display: inline-block; background: #3498db; color: white; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">
                            <i class="fas fa-money-bill"></i> Dibayar
                        </span>
                        <p style="margin: 10px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Pembayaran diterima, tunggu konfirmasi</p>
                    </div>
                    <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <span style="display: inline-block; background: #27ae60; color: white; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">
                            <i class="fas fa-check-circle"></i> Konfirmasi
                        </span>
                        <p style="margin: 10px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Booking telah dikonfirmasi</p>
                    </div>
                    <div style="text-align: center; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <span style="display: inline-block; background: #2980b9; color: white; padding: 8px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">
                            <i class="fas fa-flag-checkered"></i> Selesai
                        </span>
                        <p style="margin: 10px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Check-out selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .owner-bookings-list {
            background: #f8f9fa;
            min-height: 100vh;
        }

        .bookings-table-wrapper table tbody tr:hover {
            background: #f8f9fa;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }

        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column !important;
                gap: 15px;
                text-align: center;
            }

            .bookings-table-wrapper {
                overflow-x: auto;
            }

            .btn-group {
                flex-direction: column !important;
            }

            .btn-group form {
                width: 100%;
            }

            .btn-group button {
                width: 100%;
            }
        }
    </style>
@endsection