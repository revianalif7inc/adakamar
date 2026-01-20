<aside class="articles-widgets">
    <div class="widget-box mb-4">
        <h5 class="widget-title">Tentang Penulis Artikel</h5>
        <div class="widget-body d-flex gap-3 align-items-center">
            @php $author = \App\Models\User::where('role', 'admin')->first(); @endphp
            <div class="author-avatar">
                @if($author)
                    <div class="avatar-circle">{{ strtoupper(substr($author->name, 0, 1)) }}</div>
                @else
                    <div class="avatar-circle">A</div>
                @endif
            </div>
            <div>
                <strong>{{ $author->name ?? 'Tim AdaKamar' }}</strong>
                <p class="small text-muted mb-0">Kami berbagi tips, berita, dan panduan seputar homestay dan pariwisata.
                </p>
            </div>
        </div>
    </div>

    <div class="widget-box mb-4">
        <h5 class="widget-title">Trending Post</h5>
        <div class="widget-body">
            <ul class="list-unstyled trending-list">
                @php
                    $trending = isset($category) ? $category->articles()->published()->orderBy('published_at', 'desc')->limit(5)->get() : \App\Models\Article::published()->orderBy('published_at', 'desc')->limit(5)->get();
                @endphp
                @foreach($trending as $t)
                    <li class="trending-item">
                        <a href="{{ route('artikel.show', $t) }}">{{ \Illuminate\Support\Str::limit($t->title, 60) }}</a>
                        <div class="text-muted small">
                            {{ \Illuminate\Support\Carbon::parse($t->published_at)->format('d M Y') }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @php $hasArticleCategories = \Illuminate\Support\Facades\Schema::hasTable('article_categories'); @endphp
    <div class="widget-box mb-4">
        <h5 class="widget-title">Kategori Artikel</h5>
        <div class="widget-body">
            <ul class="list-unstyled categories-list">
                @if($hasArticleCategories)
                    @foreach(\App\Models\ArticleCategory::orderBy('name', 'asc')->get() as $c)
                        <li><a href="{{ route('artikel.category', $c->slug) }}">{{ $c->name }}</a></li>
                    @endforeach
                @else
                    <li class="text-muted">Belum ada kategori artikel</li>
                @endif
            </ul>
        </div>
    </div>
</aside>