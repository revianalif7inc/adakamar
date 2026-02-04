@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1>Edit Kamar</h1>
                    <p class="text-muted">Perbarui informasi kamar — nama, harga, gambar, dan fasilitas</p>
                </div>
                <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>

            <div class="admin-section">
                <div class="section-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <form action="{{ route('admin.kamar.update', $homestay->id) }}" method="POST"
                        enctype="multipart/form-data" class="admin-form form-kamar">
                        @csrf
                        @method('PUT')

                        @include('admin.homestays._form')

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Perbarui Kamar
                            </button>
                            <a href="{{ route('admin.kamar.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    @endsection

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('select[name="categories[]"]').forEach(function (el) {
                    if (!el.classList.contains('choices-initialized')) {
                        new Choices(el, {
                            removeItemButton: true,
                            searchEnabled: true,
                            shouldSort: false,
                            placeholderValue: 'Pilih kategori...'
                        });
                        el.classList.add('choices-initialized');
                    }
                });
            });
        </script>
    @endsection
@endsection