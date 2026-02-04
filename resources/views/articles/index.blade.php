@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endsection

@section('content')
    <div class="articles-page">
        <!-- Header -->
        <div class="articles-header">
            <div class="articles-header-content">
                <h1>Artikel & Berita</h1>
                <p class="subtitle">Panduan, tips, dan informasi seputar kost dan homestay terpercaya</p>
            </div>
        </div>

        <!-- Content -->
        <div class="articles-container">
            <div class="row">
                <div class="col-lg-9">
                    @if($articles->count())
                        <div class="articles-grid">
                            @foreach($articles as $article)
                                <div class="article-card">
                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" class="article-card-image"
                                            alt="{{ $article->title }}">
                                    @else
                                        <div class="article-card-image"></div>
                                    @endif

                                    <div class="article-card-body">
                                        @if($article->categories && $article->categories->count())
                                            @foreach($article->categories->take(1) as $cat)
                                                <span class="article-card-category">{{ $cat->name }}</span>
                                            @endforeach
                                        @endif

                                        <h3 class="article-card-title">{{ $article->title }}</h3>

                                        <p class="article-card-excerpt">
                                            {{ Str::limit($article->excerpt ?? strip_tags($article->body), 120) }}
                                        </p>

                                        <div class="article-card-meta" style="margin-top: auto;">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M Y') : 'Belum dipublikasi' }}</span>
                                        </div>

                                        <a href="{{ route('artikel.show', $article) }}" class="article-card-link">
                                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $articles->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px; background: white; border-radius: 10px;">
                            <i class="fas fa-newspaper" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
                            <p style="color: #666; font-size: 1.1rem;">Belum ada artikel yang dipublikasikan</p>
                        </div>
                    @endif
                </div>

                <div class="col-lg-3">
                    <div class="articles-sidebar">
                        @include('articles._widgets')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection