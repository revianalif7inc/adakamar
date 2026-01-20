@extends('layouts.app')

@section('title', 'Kategori Homestay')

@section('meta')
    <meta name="description"
        content="Daftar kategori homestay terbaik di AdaKamar. Temukan kategori berdasarkan fasilitas, lokasi, atau kebutuhan rombongan.">
    <link rel="canonical" href="{{ route('categories.index') }}">
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
    <div class="container categories-section categories-index section-pad">
        <div class="section-header">
            <h1>Kategori Homestay</h1>
            <p class="text-muted">Temukan homestay berdasarkan kategori. Pilih kategori untuk melihat listing khusus.</p>
        </div>

        <div class="categories-grid">
            @forelse($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="category-card">
                    <div class="cat-icon">{{ strtoupper(substr($category->name, 0, 1)) }}</div>
                    <div class="cat-body">
                        <h4>{{ $category->name }}</h4>
                        @if($category->description)
                            <p class="cat-desc">{{ \Illuminate\Support\Str::limit($category->description, 120) }}</p>
                        @endif
                    </div>
                    <div class="category-meta">
                        <span class="category-count">{{ $category->homestays_count }} unit</span>
                    </div>
                    <div class="card-arrow"><i class="fa fa-angle-right"></i></div>
                </a>
            @empty
                <p>Tidak ada kategori</p>
            @endforelse
        </div>

        <div class="mt-4 pagination-wrapper">{{ $categories->links() }}</div>
    </div>
@endsection