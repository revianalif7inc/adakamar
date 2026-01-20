@extends('layouts.app')

@section('title', $category->name . ' — Kategori')

@section('meta')
    <meta name="description"
        content="{{ \Illuminate\Support\Str::limit($category->description ?? ("Kategori " . $category->name), 160) }}">
    <link rel="canonical" href="{{ route('categories.show', $category->slug) }}">
    <script type="application/ld+json">
                    {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => $category->name,
        "description" => \Illuminate\Support\Str::limit($category->description ?? '', 160),
        "mainEntity" => [
            "@type" => "ItemList",
            "itemListElement" => $homestays->map(function ($h, $i) {
                return [
                    "@type" => "ListItem",
                    "position" => $i + 1,
                    "item" => [
                        "@id" => route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? '']),
                        "name" => $h->name,
                        "image" => !empty($h->image_url) ? asset('storage/' . $h->image_url) : asset('images/homestays/placeholder.svg'),
                        "description" => \Illuminate\Support\Str::limit($h->description ?? '', 120),
                    ]
                ];
            })->toArray()
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
                </script>
@endsection

@section('content')
    <div class="container categories-section categories-show">
        <div class="section-header">
            <div>
                <h1>{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-muted">{{ $category->description }}</p>
                @endif
            </div>



            <div>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Kembali ke Semua Kategori</a>
            </div>
        </div>

        <div class="kamar-grid">
            @forelse($homestays as $homestay)
                <div class="kamar-card">
                    @if(!empty($homestay->image_url) && \Illuminate\Support\Facades\Storage::disk('public')->exists($homestay->image_url))
                        <img src="{{ asset('storage/' . $homestay->image_url) }}" alt="{{ $homestay->name }}">
                    @else
                        <img src="{{ asset('images/homestays/placeholder.svg') }}" alt="placeholder">
                    @endif

                    <h3 title="{{ $homestay->name }}">{{ \Illuminate\Support\Str::limit($homestay->name, 36) }}</h3>
                    <p class="location">{{ $homestay->location }}</p>
                    <div class="card-meta">
                        <div class="price-pill"><svg width="16" height="16" viewBox="0 0 24 24" class="price-icon"
                                aria-hidden="true" focusable="false">
                                <path fill="currentColor"
                                    d="M12 1c-1.1 0-2 .9-2 2v1.1C7.8 4.2 6 6 6 8v1c0 2 2 2 2 2 .6 0 1.1-.2 1.5-.5.7.4 1.4.9 2.5.9 1.8 0 3-1 3-2.8V8c0-1.9-1.8-3.7-3.9-3.9V3c0-1.1-.9-2-2-2zM6 19v2h12v-2c0-2-3.6-3-6-3s-6 1-6 3z" />
                            </svg>
                            @if($homestay->price_per_month)
                                Rp {{ number_format($homestay->price_per_month, 0, ',', '.') }} / bulan
                            @elseif($homestay->price_per_year)
                                Rp {{ number_format($homestay->price_per_year, 0, ',', '.') }} / tahun
                            @else
                                Harga belum tersedia
                            @endif
                        </div>

                        <a href="{{ route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug ?? '']) }}"
                            class="btn btn-primary">Lihat Detail <span class="btn-icon" aria-hidden="true"><svg width="12"
                                    height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5l7 7-7 7"></path>
                                </svg></span></a>
                    </div>
                </div>
            @empty
                <p>Tidak ada homestay di kategori ini.</p>
            @endforelse
        </div>

        <div class="mt-4 pagination-wrapper">{{ $homestays->links() }}</div>
    </div>



@endsection