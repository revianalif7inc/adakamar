@extends('layouts.app')

@section('title', 'Manajemen Kamar - Owner')

@section('content')
    <div class="admin-kamar-list">
        <div class="container">
            <div class="admin-kamar-header enhanced">
                <div class="header-left">
                    <h1>Daftar Kamar Saya</h1>
                    <p class="text-muted">Kelola kamar yang Anda tambahkan (menunggu konfirmasi admin jika belum aktif)</p>
                    <div class="header-stats" aria-hidden="true">
                        <span class="stat-pill">Total: <strong>{{ $homestays->total() }}</strong></span>
                        <span class="stat-pill">Halaman: <strong>{{ $homestays->count() }}</strong></span>
                    </div>
                </div>

                <div class="header-actions">
                    <form method="GET" action="{{ route('owner.kamar.index') }}" class="search-form" role="search">
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama kamar..."
                            aria-label="Cari kamar" />
                        <button class="btn btn-outline btn-sm" type="submit"><i class="fa fa-search"
                                aria-hidden="true"></i></button>
                    </form>

                    <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kamar
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="kamar-list-card">
                <div class="table-responsive-wrapper">
                    <table class="table table-kamar">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($homestays as $h)
                                <tr>
                                    <td data-label="Nama">
                                        <div class="kamar-name-cell">
                                            @if(!empty($h->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url))
                                                <img src="{{ asset('storage/' . $h->image_url) }}" alt="{{ $h->name }}"
                                                    class="kamar-thumb">
                                            @else
                                                <div class="kamar-thumb-empty"><i class="fa fa-image" aria-hidden="true"></i></div>
                                            @endif
                                            <div>
                                                <p class="kamar-name">{{ $h->name }}</p>
                                                <small class="muted">Ditambahkan:
                                                    {{ optional($h->created_at)->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Harga">
                                        @if($h->price_per_month)
                                            Rp {{ number_format($h->price_per_month, 0, ',', '.') }} / bulan
                                        @elseif($h->price_per_year)
                                            Rp {{ number_format($h->price_per_year, 0, ',', '.') }} / tahun
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-label="Status">
                                        @if($h->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="{{ route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? '']) }}"
                                                target="_blank" class="btn btn-sm btn-outline"><i class="fa fa-eye"
                                                    aria-hidden="true"></i> Lihat</a>
                                            <a href="{{ route('owner.kamar.edit', $h->id) }}" class="btn btn-sm btn-edit"><i
                                                    class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                            <form action="{{ route('owner.kamar.destroy', $h->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-delete"
                                                    onclick="return confirm('Hapus kamar?')"><i class="fa fa-trash"
                                                        aria-hidden="true"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="empty-state">
                                            <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="empty" />
                                            <p class="mb-3">Belum ada kamar yang Anda tambahkan.</p>
                                            <a href="{{ route('owner.kamar.create') }}" class="btn btn-primary"><i
                                                    class="fa fa-plus"></i> Tambah Kamar Sekarang</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-wrapper">{{ $homestays->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection