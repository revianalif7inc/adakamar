@extends('layouts.app')

@section('title', 'Ubah Peran Pengguna')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Ubah Peran</h1>
                    <p class="text-muted">Ubah peran pengguna (admin, owner, customer)</p>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="admin-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="role">Peran</label>
                            <select name="role" id="role" class="form-control">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="owner" {{ $user->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="admin-form-actions">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection