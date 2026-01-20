@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kelola Kategori</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Pinned</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($category->description, 80) }}</td>
                                <td>
                                    <form action="{{ route('admin.categories.togglePin', $category) }}" method="POST">
                                        @csrf
                                        <button
                                            class="btn btn-sm {{ $category->is_pinned ? 'btn-success' : 'btn-outline' }}">{{ $category->is_pinned ? 'Pinned' : 'Pin' }}</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="category-meta">
                                        <form action="{{ route('admin.categories.move', $category) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <input type="hidden" name="direction" value="up">
                                            <button class="btn btn-sm btn-secondary">▲</button>
                                        </form>

                                        <form action="{{ route('admin.categories.move', $category) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <input type="hidden" name="direction" value="down">
                                            <button class="btn btn-sm btn-secondary">▼</button>
                                        </form>
                                        <span class="sort-order">{{ $category->sort_order }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
@endsection