@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
@endsection

@section('content')
    <div class="article-page">
        <!-- Header -->
        <div class="article-header">
            <div class="article-header-wrapper">
                <a href="{{ route('artikel.index') }}" class="back-link">
                    <i class="fas fa-chevron-left"></i> Kembali ke Artikel
                </a>
                <h1>{{ $article->title }}</h1>
                <div class="article-header-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M Y') : 'Belum dipublikasi' }}</span>
                    </div>
                    @if($article->author)
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span>{{ $article->author->name }}</span>
                        </div>
                    @endif
                    @if($article->categories && $article->categories->count())
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <span>
                                @foreach($article->categories as $cat)
                                    {{ $cat->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="article-content-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                class="article-hero">
                        @endif

                        @if($article->categories && $article->categories->count())
                            <div class="article-categories">
                                @foreach($article->categories as $cat)
                                    <a href="{{ route('artikel.category', $cat->slug) }}">
                                        <i class="fas fa-tag"></i> {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div class="article-body">
                            {!! nl2br(e($article->body)) !!}
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <div class="articles-sidebar">
                        @include('articles._widgets')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection