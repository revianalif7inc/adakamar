@extends('layouts.app')

@section('title', 'Buat Artikel')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Buat Artikel Baru</h1>
                    <p class="text-muted">Tulis dan terbitkan artikel baru.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
                        class="admin-form">
                        @include('admin.articles._form')

                        <div class="admin-form-actions mt-3">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection