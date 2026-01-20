@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Artikel</h1>
                    <p class="text-muted">Kelola artikel yang tampil di situs.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-lg"><i
                            class="fas fa-plus"></i> Baru</a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="admin-section">
                <div class="bookings-table-wrapper">
                    <table class="table table-admin">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Publikasi</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $a)
                                <tr>
                                    <td>#{{ $a->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($a->image)
                                                <img src="{{ asset('storage/' . $a->image) }}" alt="thumb" class="article-thumb">
                                            @endif
                                            <div>
                                                <strong>{{ $a->title }}</strong>
                                                <div class="text-muted small">{{ Str::limit($a->excerpt, 80) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $a->author->name ?? '—' }}</td>
                                    <td>{{ $a->published_at ? \Illuminate\Support\Carbon::parse($a->published_at)->format('d M Y') : 'Draft' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.articles.show', $a) }}" class="btn btn-xs btn-secondary"
                                            title="Lihat"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.articles.edit', $a) }}" class="btn btn-xs btn-primary"
                                            title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.articles.destroy', $a) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Hapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-danger" title="Hapus"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada artikel</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $articles->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection