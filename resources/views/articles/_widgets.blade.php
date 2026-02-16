<aside class="articles-sidebar">
    <!-- Author Widget -->
    <div class="sidebar-widget author-widget">
        <h3><i class="fas fa-user-circle"></i> Tentang Kami</h3>
        <div class="widget-content">
            @php $author = \App\Models\User::where('role', 'admin')->first(); @endphp
            <div class="author-avatar">
                {{ strtoupper(substr($author->name ?? 'AdaKamar', 0, 1)) }}
            </div>
            <div class="author-info">
                <strong>{{ $author->name ?? 'Tim AdaKamar' }}</strong>
                <p>Kami berbagi tips, panduan, dan informasi terpercaya seputar homestay dan pariwisata Indonesia.</p>
                <div class="social-links">
                    <a href="#" title="Facebook" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" title="Instagram" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" title="Twitter" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trending Widget -->
    <div class="sidebar-widget">
        <h3><i class="fas fa-fire"></i> Artikel Populer</h3>
        <div class="widget-body">
            <ul class="trending-list">
                @php
                    $trending = isset($category) ? $category->articles()->published()->orderBy('published_at', 'desc')->limit(5)->get() : \App\Models\Article::published()->orderBy('published_at', 'desc')->limit(5)->get();
                @endphp
                @foreach($trending as $t)
                    <li class="trending-item">
                        <div class="trending-counter">{{ $loop->index + 1 }}</div>
                        <a href="{{ route('artikel.show', $t) }}">
                            <span>{{ \Illuminate\Support\Str::limit($t->title, 50) }}</span>
                            <span
                                class="date">{{ \Illuminate\Support\Carbon::parse($t->published_at)->format('d M Y') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Categories Widget -->
    @php $hasArticleCategories = \Illuminate\Support\Facades\Schema::hasTable('article_categories'); @endphp
    @if($hasArticleCategories)
        <div class="sidebar-widget">
            <h3><i class="fas fa-folder"></i> Kategori Artikel</h3>
            <div class="widget-body">
                <ul class="categories-list">
                    @foreach(\App\Models\ArticleCategory::withCount('articles')->orderBy('articles_count', 'desc')->limit(5)->get() as $c)
                        <li>
                            <a href="{{ route('artikel.category', $c->slug) }}">
                                <span>{{ $c->name }}</span>
                                <span class="count">{{ $c->articles_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Subscribe Widget -->
    <div class="sidebar-widget subscribe-widget">
        <h3><i class="fas fa-bell"></i> Subscribe Newsletter</h3>
        <p>Dapatkan update artikel terbaru langsung ke email Anda</p>
        <form class="subscribe-form" action="#" method="POST">
            <input type="email" placeholder="Masukkan email Anda..." required>
            <button type="submit"><i class="fas fa-paper-plane"></i> Subscribe</button>
        </form>
    </div>
</aside>