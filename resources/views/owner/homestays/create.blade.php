@extends('layouts.app')

@section('title', 'Tambah Kamar - Owner')

@section('content')
    <div class="admin-dashboard">
        <div class="container">
            <div class="admin-header">
                <div>
                    <h1><i class="fas fa-door-open"></i> Tambah Kamar Baru</h1>
                    <p class="text-muted">Buat listing kamar baru dengan informasi lengkap</p>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Terdapat Kesalahan</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('owner.kamar.store') }}" method="POST" enctype="multipart/form-data"
                        class="admin-form form-kamar">
                        @csrf
                        @include('owner.homestays._form')

                        <div class="admin-form-actions">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Simpan Kamar</button>
                            <a href="{{ route('owner.kamar.index') }}" class="btn btn-secondary btn-lg"><i class="fas fa-times"></i> Batal</a>
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