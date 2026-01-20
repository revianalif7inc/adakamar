<section class="hero-section bg-image">
    <div class="hero-inner container text-center">
        <h1>Selamat Datang di AdaKamar</h1>
        <p class="lead">Temukan dan sewa homestay terbaik di Indonesia</p>

        <div class="hero-search">
            <form action="{{ route('homestays.index') }}" class="search-box" method="GET">
                <input type="text" name="q" class="form-control search-input"
                    placeholder="Cari homestay, lokasi, atau fasilitas...">
                <select name="city" class="form-select search-select">
                    <option value="">Semua Kota</option>
                    <option value="yogyakarta">Yogyakarta</option>
                    <option value="jakarta">Jakarta</option>
                </select>
                <button class="btn btn-search" type="submit">Cari</button>
            </form>
        </div>
    </div>
</section>