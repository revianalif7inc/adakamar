@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
    <div class="container py-4">
        <div class="card booking-detail-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h3 class="mb-1">Detail Pemesanan <small class="text-muted">#{{ $booking->id }}</small></h3>
                        <div class="small text-muted">Dibuat: {{ $booking->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-status badge-lg">{{ ucfirst($booking->status) }}</span>
                        <div class="mt-2">
                            <button class="btn btn-outline btn-sm me-1" onclick="window.print()"><i class="fa fa-print"></i>
                                Cetak</button>
                            <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">Beranda</a>
                        </div>
                    </div>
                </div>

                <div class="booking-grid row">
                    <div class="col-md-4">
                        <div class="thumb mb-3">
                            @php $img = $booking->homestay->image_url ?? null; @endphp
                            @if($img && \Illuminate\Support\Facades\Storage::disk('public')->exists($img))
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $booking->homestay->name }}"
                                    class="img-fluid rounded">
                            @else
                                <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder"
                                    class="img-fluid rounded">
                            @endif
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item p-2">
                                <strong>{{ $booking->homestay->name }}</strong>
                                <div class="small text-muted">{{ $booking->homestay->location }}</div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Check-in</strong>
                                <div class="small">{{ optional($booking->check_in_date)->format('d M Y') ?? '—' }}</div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Check-out</strong>
                                <div class="small">{{ optional($booking->check_out_date)->format('d M Y') ?? '—' }}</div>
                            </div>

                            <div class="list-group-item p-2">
                                <strong>Jumlah Tamu</strong>
                                <div class="small">{{ $booking->total_guests }}</div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <h5>Rincian Pembayaran</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td class="text-end">Rp 0</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td class="text-end">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="mb-3">
                            <h5>📝 Data Diri Pemesan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>{{ $booking->nama ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td><a href="mailto:{{ $booking->email }}">{{ $booking->email ?? '—' }}</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Nomor HP</strong></td>
                                    <td><a href="tel:{{ $booking->nomor_hp }}">{{ $booking->nomor_hp ?? '—' }}</a></td>
                                </tr>
                            </table>
                        </div>

                        <div class="mb-3">
                            <h5>Status dan Tindakan</h5>

                            {{-- Status timeline --}}
                            <div class="booking-timeline mb-3">
                                @php
                                    $steps = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Lunas', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                                @endphp

                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($steps as $key => $label)
                                        <div
                                            class="timeline-step {{ $booking->status === $key ? 'active' : (array_search($key, array_keys($steps)) < array_search($booking->status, array_keys($steps)) ? 'done' : '') }}">
                                            <div class="step-dot"></div>
                                            <div class="step-label small">{{ $label }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Actions: pay / upload proof for booking owner --}}
                            <div>
                                @if(auth()->id() === $booking->user_id && $booking->status === 'pending')
                                    <a href="{{ route('booking.pay.form', $booking->id) }}" class="btn btn-primary me-2">Bayar /
                                        Unggah Bukti</a>
                                @endif

                                {{-- Owner/Admin: status update form --}}
                                @php
                                    $user = auth()->user();
                                    $isOwner = $user && $booking->homestay && $user->id === $booking->homestay->owner_id;
                                    $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
                                @endphp

                                @if($isOwner || $isAdmin)
                                    <form
                                        action="{{ $isAdmin ? route('admin.bookings.updateStatus', $booking->id) : route('owner.bookings.updateStatus', $booking->id) }}"
                                        method="POST" class="d-inline-block mt-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <select name="status" class="form-select">
                                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>
                                                    Menunggu Pembayaran</option>
                                                <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Lunas
                                                </option>
                                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                            <button class="btn btn-primary">Perbarui Status</button>
                                        </div>
                                    </form>
                                @endif

                                {{-- Admin: delete action --}}
                                @if($isAdmin)
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                        class="d-inline-block ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus booking ini?')">Hapus</button>
                                    </form>
                                @endif

                            </div>

                        </div>

                        <div class="mb-3">
                            <h5>Kontak Pemilik</h5>
                            @if($booking->homestay->owner)
                                <p>{{ $booking->homestay->owner->name }} —
                                    {{ $booking->homestay->owner->phone ?? $booking->homestay->owner->email }}</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection