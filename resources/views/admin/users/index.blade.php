@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-management.css') }}">
@endsection

@section('content')
    <div class="admin-list-page">
        <div class="container">
            <!-- Header -->
            <div class="admin-list-header">
                <div class="admin-list-header-left">
                    <h1>Manajemen Pengguna</h1>
                    <p class="text-muted">Lihat dan kelola semua akun pengguna dan peran mereka</p>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            <!-- Users List -->
            <div class="list-card">

                <div class="filters">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="filters-form">
                        <div class="search-input-wrapper">
                            <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}" 
                                placeholder="Cari nama atau email..." class="form-control" />
                            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                        </div>

                        <select name="role" class="form-control">
                            <option value="">Semua Peran</option>
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}" {{ (old('role', $role ?? request('role')) === $key) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <a href="{{ route('admin.users.index') }}" class="btn btn-reset"><i class="fas fa-redo"></i> Reset</a>

                        <div class="filter-info">Total: <strong>{{ $users->total() }}</strong> pengguna</div>
                    </form>
                </div>

                <div class="users-grid-container">
                    @forelse($users as $user)
                        <div class="user-card">
                            <div class="user-card-header">
                                <div class="user-avatar">
                                    <span class="avatar-initials">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="user-role-badge">
                                    <span class="badge role-badge role-{{ $user->role }}">
                                        <i class="fas {{ 
                                            $user->role === 'admin' ? 'fa-shield-alt' : 
                                            ($user->role === 'owner' ? 'fa-home' : 'fa-user')
                                        }}"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="user-card-content">
                                <h3 class="user-card-name">{{ $user->name }}</h3>

                                <div class="user-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:{{ $user->email }}" class="user-email">{{ $user->email }}</a>
                                </div>

                                @if($user->phone)
                                    <div class="user-info-item">
                                        <i class="fas fa-phone"></i>
                                        <a href="tel:{{ $user->phone }}" class="user-phone">{{ $user->phone }}</a>
                                    </div>
                                @endif

                                <div class="user-info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span class="user-joined">Bergabung {{ $user->created_at->format('d M Y') }}</span>
                                </div>

                                @if($user->role === 'owner')
                                    <div class="user-stats">
                                        <div class="stat-item">
                                            <span class="stat-value">{{ $user->homestays()->count() }}</span>
                                            <span class="stat-label">Kamar</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value">{{ $user->bookings()->count() }}</span>
                                            <span class="stat-label">Booking</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="user-card-footer">
                                <div class="user-actions">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Ubah Peran
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" style="flex: 1;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" style="width: 100%; justify-content: center;" onclick="return confirm('Hapus pengguna ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge badge-info" style="flex: 1; text-align: center; padding: 8px 12px;">Akun Anda</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-full">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p class="text-muted">Belum ada pengguna</p>
                        </div>
                    @endforelse
                </div>

                <div class="pagination-wrapper">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
@endsection