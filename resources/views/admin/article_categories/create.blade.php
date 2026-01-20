@extends('layouts.app')

@section('title', 'Buat Kategori Artikel')

@section('content')
    <div class="container mt-4">
        <h1>Buat Kategori Artikel</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.article-categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug (opsional)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.article-categories.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection