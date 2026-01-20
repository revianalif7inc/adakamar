@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Manajemen Pengguna</h1>
                    <p class="text-muted">Lihat dan kelola semua akun pengguna, khususnya pemilik (owner)</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="admin-section">
                <div class="section-body">

                    <div class="filters">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="filters-form">
                            <input type="text" name="q" value="{{ old('q', $q ?? request('q')) }}" placeholder="Cari nama atau email..."
                                   class="form-control" />
                            <select name="role" class="form-control">
                                <option value="">Semua peran</option>
                                @foreach($roles as $key => $label)
                                    <option value="{{ $key }}" {{ (old('role', $role ?? request('role')) === $key) ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Cari</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                            <div class="ml-auto muted-count">Menampilkan {{ $users->total() }} pengguna</div>
                        </form>
                    </div>
                    <div class="table-responsive-wrapper">
                        <table class="table table-admin">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th width="160">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-info">Ubah Role</a>
                                            @if(auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Hapus pengguna ini?')">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pengguna</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pagination-wrapper">{{ $users->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection