@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-management.css') }}">
@endsection

@section('content')
    <div class="admin-list-page">
        <div class="container">
            <!-- Header -->
            <div class="admin-list-header">
                <div class="admin-list-header-left">
                    <h1>Artikel</h1>
                    <p class="text-muted">Kelola artikel yang tampil di situs</p>
                </div>
                <div class="admin-list-header-right">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Buat Artikel Baru
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

            <!-- Articles List -->
            <div class="list-card">
                <div class="articles-grid-container">
                    @forelse($articles as $a)
                        <div class="article-card">
                            <div class="article-card-image">
                                @if($a->image)
                                    <img src="{{ asset('storage/' . $a->image) }}" alt="{{ $a->title }}" />
                                @else
                                    <div class="article-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="article-card-overlay">
                                    <a href="{{ route('admin.articles.show', $a) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </div>
                            </div>

                            <div class="article-card-content">
                                <div class="article-card-header">
                                    <div class="article-id">#{{ $a->id }}</div>
                                    <div class="article-status">
                                        @if($a->published_at)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Published
                                            </span>
                                        @else
                                            <span class="badge badge-draft">
                                                <i class="fas fa-file"></i> Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <h3 class="article-card-title">{{ $a->title }}</h3>

                                <p class="article-card-excerpt">{{ Str::limit($a->excerpt, 120) }}</p>

                                <div class="article-card-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $a->author->name ?? '—' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>
                                            @if($a->published_at)
                                                {{ \Illuminate\Support\Carbon::parse($a->published_at)->format('d M Y') }}
                                            @else
                                                Belum dipublikasikan
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="article-card-footer">
                                <div class="article-actions">
                                    <a href="{{ route('admin.articles.show', $a) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $a) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $a) }}" method="POST" class="d-inline"
                                        style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" style="width: 100%; justify-content: center;"
                                            onclick="return confirm('Hapus artikel ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-full">
                            <i class="fas fa-inbox empty-icon"></i>
                            <p class="text-muted">Belum ada artikel. <a href="{{ route('admin.articles.create') }}">Buat artikel
                                    sekarang</a></p>
                        </div>
                    @endforelse
                </div>
                <div class="pagination-wrapper">{{ $articles->links() }}</div>
            </div>
        </div>
    </div>
@endsection