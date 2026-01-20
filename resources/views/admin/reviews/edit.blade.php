@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-reviews.css') }}">
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Edit Ulasan</h1>
                    <p class="text-muted">Ubah rating atau komentar pengguna.</p>
                </div>
                <div class="admin-header-actions">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <div class="admin-section">
                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <input class="form-control" value="{{ $review->user->name }} ({{ $review->user->email }})" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Homestay</label>
                        <select name="homestay_id" class="form-select">
                            @foreach($homestays as $h)
                                <option value="{{ $h->id }}" {{ $review->homestay_id == $h->id ? 'selected' : '' }}>{{ $h->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5"
                            value="{{ $review->rating }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea name="comment" class="form-control" rows="5">{{ $review->comment }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection