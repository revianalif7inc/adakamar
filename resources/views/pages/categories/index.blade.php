@extends('layouts.app')

@section('title', 'Kategori Homestay')

@section('meta')
    <meta name="description"
        content="Daftar kategori homestay terbaik di AdaKamar. Temukan kategori berdasarkan fasilitas, lokasi, atau kebutuhan rombongan.">
    <link rel="canonical" href="{{ route('categories.index') }}">
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
    <script type="application/ld+json">
        {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "ItemList",
        "itemListElement" => $categories->map(function ($c, $i) {
            return [
                "@type" => "ListItem",
                "position" => $i + 1,
                "item" => [
                    "@id" => route('categories.show', $c->slug),
                    "name" => $c->name,
                    "description" => \Illuminate\Support\Str::limit($c->description ?? '', 160)
                ]
            ];
        })->toArray()
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
@endsection

@section('content')
    <div class="categories-page">
        <!-- Header -->
        <div class="categories-header">
            <div class="container">
                <div class="header-content">
                    <h1>Kategori Homestay</h1>
                    <p class="subtitle">Temukan homestay berdasarkan kategori pilihan Anda</p>
                </div>
            </div>
        </div>

        <!-- Categories Container -->
        <div class="container categories-container">
            <!-- Filter & Search Section -->
            <div class="categories-filter-section">
                <div class="filter-wrapper">
                    <div class="search-box-categories">
                        <input type="text" id="categorySearch" class="search-input-categories"
                            placeholder="Cari kategori..." aria-label="Cari kategori homestay">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="categories-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $categories->count() }}</span>
                    <span class="stat-label">Kategori</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $categories->sum('homestays_count') }}</span>
                    <span class="stat-label">Total Homestay</span>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="categories-grid" id="categoriesGrid">
                @forelse($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="category-card"
                        data-name="{{ strtolower($category->name) }}">
                        <div class="card-header">
                            <div class="cat-icon">{{ strtoupper(substr($category->name, 0, 1)) }}</div>
                        </div>
                        <div class="card-body">
                            <h3 class="cat-name">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="cat-desc">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="footer-content">
                                <span class="cat-count">
                                    <i class="fas fa-home"></i>
                                    {{ $category->homestays_count }} unit
                                </span>
                            </div>
                            <span class="arrow"><i class="fa fa-arrow-right"></i></span>
                        </div>
                    </a>
                @empty
                    <div class="no-categories" style="grid-column: 1 / -1;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 3.5rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                            <p style="font-size: 1.1rem; color: #718096; margin: 0;">Tidak ada kategori tersedia saat ini</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message -->
            <div class="no-results-message" id="noResults" style="display: none;">
                <div class="no-categories" style="grid-column: 1 / -1;">
                    <div class="empty-state">
                        <i class="fas fa-search" style="font-size: 3.5rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                        <p style="font-size: 1.1rem; color: #718096; margin: 0;">Tidak ada kategori yang cocok dengan
                            pencarian Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('categorySearch');
            const categoriesGrid = document.getElementById('categoriesGrid');
            const categoryCards = document.querySelectorAll('.category-card');
            const noResults = document.getElementById('noResults');

            searchInput.addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleCount = 0;

                categoryCards.forEach(card => {
                    const categoryName = card.dataset.name;
                    const isVisible = categoryName.includes(searchTerm);

                    if (searchTerm === '') {
                        card.style.display = '';
                        card.style.animation = 'fadeIn 0.3s ease';
                        visibleCount++;
                    } else if (isVisible) {
                        card.style.display = '';
                        card.style.animation = 'fadeIn 0.3s ease';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                noResults.style.display = visibleCount === 0 && searchTerm !== '' ? 'block' : 'none';
            });
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection