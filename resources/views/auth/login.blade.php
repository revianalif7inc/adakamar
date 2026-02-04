@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-container">
        <div class="auth-box auth-box-premium">
            <div class="auth-header">
                <img src="{{ asset('images/logoAdaKamar.png') }}" alt="AdaKamar" class="auth-logo">
                <h1>Masuk Akun</h1>
                <p class="auth-subtitle">Temukan kamar impianmu bersama kami</p>
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

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com" class="form-control-premium">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password Anda"
                        class="form-control-premium">
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    <span><i class="fas fa-sign-in-alt"></i> Masuk</span>
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <p class="auth-link">
                Belum punya akun?
                <a href="{{ route('register') }}" class="auth-link-action">Daftar di sini</a>
            </p>
        </div>
    </div>
@endsection