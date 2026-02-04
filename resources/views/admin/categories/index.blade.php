@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-management.css') }}">
@endsection

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-tag"></i> Kelola Kategori</h1>
                    <p class="text-muted">Atur kategori kamar dan urutan tampilannya</p>
                </div>
                <div>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Categories List -->
            <div class="admin-section">
                <div class="section-header">
                    <h2>Daftar Kategori</h2>
                    <span class="badge bg-primary">{{ $categories->total() }} kategori</span>
                </div>
                <div class="section-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th width="60" class="text-center">#</th>
                                    <th>Nama Kategori</th>
                                    <th width="200">Slug</th>
                                    <th>Deskripsi</th>
                                    <th width="100" class="text-center">Pin</th>
                                    <th width="140" class="text-center">Urutan</th>
                                    <th width="180" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="table-row-hover">
                                        <td class="text-center text-muted">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2" style="width: 8px; height: 8px; background: var(--primary); border-radius: 50%;"></div>
                                                <span class="fw-semibold">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <code style="background: var(--light-bg); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $category->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.categories.togglePin', $category) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $category->is_pinned ? 'btn-warning' : 'btn-outline-secondary' }}" 
                                                    title="{{ $category->is_pinned ? 'Tidak di-pin' : 'Pin' }}" style="border: none;">
                                                    <i class="fas fa-thumbtack"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <form action="{{ route('admin.categories.move', $category) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="direction" value="up">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Naik">
                                                        <i class="fas fa-chevron-up"></i>
                                                    </button>
                                                </form>
                                                <span class="btn btn-outline-secondary btn-sm" style="cursor: default; pointer-events: none; border-left: 0; border-right: 0;">{{ $category->sort_order ?? 'N/A' }}</span>
                                                <form action="{{ route('admin.categories.move', $category) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="direction" value="down">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Turun">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="deleteCategory('{{ $category->id }}', '{{ $category->name }}')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fas fa-inbox" style="font-size: 3rem; color: var(--muted); margin-bottom: 1rem;"></i>
                                            <p class="text-muted">Belum ada kategori</p>
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm mt-3">
                                                <i class="fas fa-plus"></i> Tambah Kategori Pertama
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $categories->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <form id="deleteForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
    function deleteCategory(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${name}"? Tindakan ini tidak dapat dibatalkan.`)) {
            document.getElementById('deleteForm').action = "{{ url('admin/categories') }}/" + id;
            document.getElementById('deleteForm').submit();
        }
    }
    </script>
@endsection