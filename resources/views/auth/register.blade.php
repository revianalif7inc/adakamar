@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="auth-container">
        <div class="auth-box auth-box-premium">
            <div class="auth-header">
                <img src="{{ asset('images/logoAdaKamar.png') }}" alt="AdaKamar" class="auth-logo">
                <h1>Buat Akun Baru</h1>
                <p class="auth-subtitle">Bergabunglah dengan ribuan pengguna kami</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ups! Ada kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com" class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+62 812-3456-7890"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                        class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        placeholder="Ulangi password Anda" class="form-control-premium">
                </div>

                <button type="submit" class="btn btn-primary btn-login">Daftar Sekarang</button>
            </form>

            <div class="auth-divider">atau</div>

            <p class="auth-link">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="auth-link-action">Login di sini</a>
            </p>
        </div>
    </div>
@endsection