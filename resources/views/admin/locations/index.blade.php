@extends('layouts.app')

@section('title', 'Kelola Lokasi')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Kelola Lokasi</h1>
            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">Tambah Lokasi</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->slug }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($location->description, 80) }}</td>
                                <td>
                                    <a href="{{ route('admin.locations.edit', $location) }}"
                                        class="btn btn-sm btn-secondary">Edit</a>
                                    <form action="{{ route('admin.locations.destroy', $location) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus lokasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $locations->links() }}
        </div>
    </div>
@endsection