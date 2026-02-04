@extends('layouts.app')

@section('title', 'Kategori Artikel')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-management.css') }}">
@endsection

@section('content')
    <div class="admin-list-page">
        <div class="container">
            <!-- Header -->
            <div class="admin-list-header">
                <div class="admin-list-header-left">
                    <h1>Kategori Artikel</h1>
                    <p class="text-muted">Kelola kategori untuk artikel di situs</p>
                </div>
                <div class="admin-list-header-right">
                    <a href="{{ route('admin.article-categories.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Buat Kategori
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-dismiss="alert"></button>
                </div>
            @endif

            <!-- Categories List -->
            <div class="list-card">
                <div class="table-responsive-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th width="200">Slug</th>
                                <th>Deskripsi</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $c)
                                <tr>
                                    <td>
                                        <div class="table-cell-title">{{ $c->name }}</div>
                                    </td>
                                    <td>
                                        <code
                                            style="background: var(--light-bg); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $c->slug }}</code>
                                    </td>
                                    <td>
                                        <div class="table-cell-description">{{ Str::limit($c->description, 100) }}</div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.article-categories.edit', $c) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.article-categories.destroy', $c) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus kategori ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center empty-state">
                                        <i class="fas fa-inbox empty-icon"></i>
                                        <p class="text-muted">Belum ada kategori. <a
                                                href="{{ route('admin.article-categories.create') }}">Buat kategori sekarang</a>
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
@endsection