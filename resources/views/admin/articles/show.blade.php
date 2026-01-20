@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>{{ $article->title }}</h1>
                    <p class="text-muted">
                        {{ $article->published_at ? 'Diterbitkan ' . \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : 'Draft' }}
                    </p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary btn-sm">Edit</a>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                @if($article->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="cover" class="article-hero">
                    </div>
                @endif
                <div class="article-body">{!! nl2br(e($article->body)) !!}</div>
            </div>
        </div>
    </div>
@endsection