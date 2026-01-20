@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <a href="{{ route('artikel.index') }}" class="btn btn-link">&larr; Kembali ke Artikel</a>

        <div class="row">
            <div class="col-lg-8">
                <article class="mt-3">
                    @if($article->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                class="article-hero img-fluid" />
                        </div>
                    @endif
                    <h1>{{ $article->title }}</h1>
                    <p class="text-muted">
                        {{ $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : '' }}
                        @if($article->author) • oleh {{ $article->author->name }} @endif
                    </p>

                    @if($article->categories && $article->categories->count())
                        <p class="mt-2">
                            Kategori:
                            @foreach($article->categories as $cat)
                                <a
                                    href="{{ route('artikel.category', $cat->slug) }}">{{ $cat->name }}</a>{{ !$loop->last ? ',' : '' }}
                            @endforeach
                        </p>
                    @endif

                    <div class="mt-4">{!! nl2br(e($article->body)) !!}</div>
                </article>
            </div>

            <div class="col-lg-4">
                @include('articles._widgets')
            </div>
        </div>
    </div>
@endsection