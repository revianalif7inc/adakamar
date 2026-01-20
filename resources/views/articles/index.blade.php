@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @if(isset($category))
            <h1 class="mb-4">Kategori: {{ $category->name }}</h1>
            @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
            @endif
        @else
            <h1 class="mb-4">Artikel</h1>
        @endif

        @php $hasArticleCategories = \Illuminate\Support\Facades\Schema::hasTable('article_categories'); @endphp
        @if($hasArticleCategories)
            <div class="d-block d-md-none mb-3">
                <select id="mobileArticleCategorySelect" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\ArticleCategory::orderBy('name','asc')->get() as $cat)
                        <option value="{{ $cat->slug }}" {{ isset($category) && $category->id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                @if($articles->count())
                    <div class="row">
                        @foreach($articles as $article)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top article-card-img" alt="{{ $article->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d M Y') : '' }}</p>
                                        <p class="card-text">{{ Str::limit($article->excerpt ?? strip_tags($article->body), 150) }}</p>
                                        <a href="{{ route('artikel.show', $article) }}" class="btn btn-primary">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $articles->links() }}
                @else
                    <p>Tidak ada artikel dipublikasikan.</p>
                @endif
            </div>

            <div class="col-lg-4">
                @include('articles._widgets')
            </div>
        </div>
    </div>
@endsection