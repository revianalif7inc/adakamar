@extends('layouts.app')

@section('title', 'Kategori Artikel')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kategori Artikel</h1>
            <a href="{{ route('admin.article-categories.create') }}" class="btn btn-primary">Buat Kategori</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->slug }}</td>
                        <td>{{ Str::limit($c->description, 80) }}</td>
                        <td>
                            <a href="{{ route('admin.article-categories.edit', $c) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.article-categories.destroy', $c) }}" method="POST"
                                class="d-inline-block" onsubmit="return confirm('Hapus kategori?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
@endsection