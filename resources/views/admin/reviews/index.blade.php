@extends('layouts.app')

@section('title', 'Manage Reviews')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-reviews.css') }}">
<div class="admin-dashboard">
    <div class="container">
        <div class="admin-header">
            <div>
                <h1>Kelola Ulasan</h1>
                <p class="text-muted">Lihat, sunting, atau hapus ulasan yang diberikan oleh pengguna.</p>
            </div>
            <div class="admin-header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="admin-section">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        <input type="text" name="q" class="form-control" placeholder="Cari user, homestay, atau komentar..." value="{{ $q }}">
                    </div>

                    <div class="col-lg-3 mb-2">
                        <select name="user_id" class="form-select">
                            <option value="">Semua Pengguna</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 mb-2">
                        <select name="homestay_id" class="form-select">
                            <option value="">Semua Homestay</option>
                            @foreach($homestays as $h)
                                <option value="{{ $h->id }}" {{ request('homestay_id') == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 mb-2">
                        <select name="rating" class="form-select">
                            <option value="">Semua Rating</option>
                            @for($i=5; $i>=1; $i--)
                                <option value="{{ $i }}" {{ request('rating') == (string) $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            @if($reviews->count())
                <table class="table table-admin">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>User</th>
                            <th>Homestay</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $r)
                            <tr>
                                <td>#{{ $r->id }}</td>
                                <td>{{ $r->user->name }}<br><small class="text-muted">{{ $r->user->email }}</small></td>
                                <td>{{ $r->homestay->name ?? '-' }}</td>
                                <td>{{ $r->rating }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($r->comment, 80) }}</td>
                                <td>
                                    <a href="{{ route('admin.reviews.edit', $r->id) }}" class="btn btn-sm btn-info">Sunting</a>
                                    <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus ulasan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $reviews->links() }}
            @else
                <p class="text-muted">Belum ada ulasan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
