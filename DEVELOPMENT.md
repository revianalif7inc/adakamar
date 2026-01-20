# PANDUAN PENGEMBANGAN ADAKAMAR

## 🎯 Tujuan Aplikasi

AdaKamar adalah platform booking homestay yang menghubungkan pemilik akomodasi dengan calon tamu yang mencari tempat menginap. Aplikasi ini dibangun dengan Laravel dan dirancang untuk kemudahan penggunaan.

## 📚 Dokumentasi Lengkap

### 1. Instalasi Awal

- Pastikan PHP 8.1+ terinstal
- Pastikan MySQL 5.7+ terinstal
- Jalankan `composer install`
- Setup `.env` file
- Jalankan `php artisan migrate`
- Jalankan `php artisan key:generate`

### 2. Struktur Folder

#### app/Models/

- **User** - Model user dengan roles (admin, owner, customer)
- **Homestay** - Model homestay/akomodasi
- **Booking** - Model pemesanan
- **Review** - Model ulasan/review

#### app/Http/Controllers/

- **HomeController** - Halaman utama
- **HomestayController** - CRUD homestay
- **BookingController** - Proses booking
- **AdminController** - Dashboard admin
- **AuthController** - Login/Register

#### resources/views/

- **layouts/app.blade.php** - Layout utama
- **pages/** - Halaman publik
- **admin/** - Halaman admin
- **auth/** - Form login/register
- **booking/** - Form booking
- **homestay/** - Detail homestay

### 3. User Roles

#### Admin (admin@adakamar.id / password123)

- Akses ke semua fitur
- Lihat dashboard dengan statistik
- Kelola semua homestay
- Kelola semua pemesanan
- Verifikasi homestay baru

#### Owner (owner@adakamar.id / password123)

- Tambah homestay baru
- Edit homestay milik sendiri
- Lihat pemesanan homestay mereka
- Update status pemesanan
- Lihat rating dan review

#### Customer (customer@adakamar.id / password123)

- Browse homestay
- Melakukan pemesanan
- Lihat riwayat pemesanan
- Memberikan review dan rating

## 🔧 Mengatur Database

### Migrasi Database

```bash
php artisan migrate
```

### Reset Database (Hapus semua data)

```bash
php artisan migrate:reset
php artisan migrate
```

### Refresh Database (Reset + Seed)

```bash
php artisan migrate:refresh --seed
```

## 🎨 Customization

### Mengubah Nama Aplikasi

1. Edit `APP_NAME` di `.env`
2. Edit nama di `config/app.php`
3. Update brand name di `resources/views/layouts/app.blade.php`

### Mengubah Warna

Edit variabel CSS di `public/css/style.css`:

```css
:root {
  --primary-color: #2c3e50;
  --secondary-color: #e74c3c;
  /* dst */
}
```

### Menambah Fitur Baru

Contoh: Menambah fitur "Wishlist"

1. Buat Migration:

```bash
php artisan make:migration create_wishlists_table
```

2. Edit migration file dengan schema
3. Jalankan migration:

```bash
php artisan migrate
```

4. Buat Model:

```bash
php artisan make:model Wishlist
```

5. Buat Controller:

```bash
php artisan make:controller WishlistController
```

6. Tambahkan routes di `routes/web.php`
7. Buat views yang diperlukan

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Generate `APP_KEY` yang aman
- [ ] Setup database production
- [ ] Jalankan migration di production
- [ ] Setup SSL/HTTPS
- [ ] Konfigurasi email SMTP
- [ ] Setup backup database
- [ ] Configure storage permissions

## 🐛 Troubleshooting

### Error: SQLSTATE[HY000] [2002] No such file or directory

**Solusi**: Pastikan MySQL berjalan

```bash
# Windows
net start MySQL80

# Linux
sudo service mysql start
```

### Error: Class not found

**Solusi**: Jalankan autoload dump

```bash
composer dump-autoload
```

### Error: Permission denied

**Solusi**: Set folder permissions

```bash
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

## 📖 Referensi

- [Laravel Official Docs](https://laravel.com/docs)
- [Blade Template Engine](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Routing](https://laravel.com/docs/routing)

## 💡 Tips Development

1. **Debug Mode**

   - Set `APP_DEBUG=true` untuk development
   - Gunakan `dd()` untuk debug variable
   - Gunakan `Log::info()` untuk logging

2. **Database**

   - Selalu backup sebelum migrasi
   - Gunakan transactions untuk operasi kompleks
   - Test query di artisan tinker

3. **Security**

   - Selalu validate input dengan validation rules
   - Gunakan middleware untuk protect routes
   - Hash password dengan bcrypt

4. **Performance**
   - Gunakan eager loading untuk relations
   - Pagination untuk large datasets
   - Cache frequently accessed data

## 📞 Support

Untuk bantuan atau pertanyaan, silakan hubungi developer.
