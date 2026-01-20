# AdaKamar - Platform Sewa Homestay Online

Selamat datang di **AdaKamar**, platform booking homestay yang memudahkan Anda untuk menemukan dan menyewa akomodasi pilihan di seluruh Indonesia.

## 📋 Fitur Utama

### Untuk Tamu (Customer)

- ✅ Browsing daftar homestay dengan filter dan pencarian
- ✅ Melihat detail homestay lengkap (foto, fasilitas, rating)
- ✅ Membuat pemesanan dengan tanggal pilihan
- ✅ Mengelola pemesanan saya
- ✅ Memberikan ulasan dan rating

### Untuk Pemilik Homestay (Owner)

- ✅ Menambah dan mengelola daftar homestay
- ✅ Upload foto homestay
- ✅ Atur harga dan ketersediaan
- ✅ Kelola pemesanan yang masuk
- ✅ Lihat rating dan ulasan

### Untuk Admin

- ✅ Dashboard monitoring
- ✅ Kelola semua homestay
- ✅ Verifikasi homestay baru
- ✅ Kelola semua pemesanan
- ✅ Lihat laporan dan statistik

## 🛠️ Stack Teknologi

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: Blade Template, HTML5, CSS3, JavaScript
- **Authentication**: Laravel Authentication
- **Storage**: Local File System

## 📂 Struktur Folder

```
adakamar/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Logic aplikasi
│   │   └── Middleware/        # Middleware auth & verifikasi
│   └── Models/                # Model database
├── database/
│   ├── migrations/            # Skema database
│   └── seeders/               # Data dummy
├── resources/
│   ├── views/                 # Template Blade
│   │   ├── layouts/          # Layout utama
│   │   ├── pages/            # Halaman publik
│   │   ├── admin/            # Halaman admin
│   │   ├── booking/          # Halaman pemesanan
│   │   ├── auth/             # Halaman login/register
│   │   └── homestay/         # Halaman detail homestay
│   └── css/
├── public/
│   ├── css/                   # Style sheet
│   ├── js/                    # JavaScript
│   └── images/                # Gambar statis
├── routes/
│   └── web.php               # Routing aplikasi
└── config/
    ├── app.php               # Konfigurasi aplikasi
    └── database.php          # Konfigurasi database
```

## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/adakamar.git
cd adakamar
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dan konfigurasi database:

```env
DB_DATABASE=adakamar
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. (Opsional) Seed Database

```bash
php artisan db:seed
```

### 7. Jalankan Development Server

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 📱 Halaman Utama

### Public Pages

- **Beranda** (`/`) - Tampilan utama dengan homestay pilihan
- **Daftar Homestay** (`/homestays`) - Semua homestay dengan filter
- **Detail Homestay** (`/homestays/{id}`) - Detail lengkap homestay
- **Login** (`/login`) - Form login
- **Register** (`/register`) - Form registrasi

### Admin Pages

- **Dashboard Admin** (`/admin`) - Ringkasan statistik
- **Manajemen Homestay** (`/admin/homestays`) - CRUD homestay
- **Manajemen Pemesanan** (`/admin/bookings`) - Kelola pemesanan

### Customer Pages

- **Booking Form** (`/booking/{id}`) - Form pemesanan
- **Konfirmasi Booking** (`/booking/confirmation/{id}`) - Konfirmasi pemesanan

## 🔐 Autentikasi & Otorisasi

### User Roles

- **Admin**: Akses penuh ke seluruh sistem
- **Owner**: Kelola homestay milik sendiri
- **Customer**: Browse dan booking homestay

### Middleware

- `auth` - Cek user sudah login
- `admin` - Cek user adalah admin

## 💾 Database Schema

### Table: users

```sql
id, name, email, password, phone, role, email_verified_at, timestamps
```

### Table: homestays

```sql
id, owner_id, name, description, location, price_per_night,
max_guests, bedrooms, bathrooms, image_url, amenities, rating,
is_active, timestamps
```

### Table: bookings

```sql
id, user_id, homestay_id, check_in_date, check_out_date,
total_guests, total_price, status, special_requests, timestamps
```

### Table: reviews

```sql
id, user_id, homestay_id, rating, comment, timestamps
```

## 📝 Status Pemesanan

- **pending** - Menunggu konfirmasi dari pemilik
- **confirmed** - Sudah dikonfirmasi
- **completed** - Pemesanan selesai
- **cancelled** - Dibatalkan

## 🎨 Customization

### Mengubah Nama Aplikasi

Edit di `.env`:

```env
APP_NAME="AdaKamar"
```

Dan di `config/app.php`:

```php
'name' => env('APP_NAME', 'AdaKamar'),
```

### Mengubah Logo & Brand

- Update `resources/views/layouts/app.blade.php`
- Ganti logo di `public/images/`

### Mengubah Warna & Style

- Edit `public/css/style.css`
- Ubah CSS variables di bagian `:root`

## 📋 Endpoints API

### Public

- `GET /` - Halaman beranda
- `GET /homestays` - Daftar homestay
- `GET /homestays/{id}` - Detail homestay
- `GET /login` - Form login
- `POST /login` - Proses login
- `GET /register` - Form register
- `POST /register` - Proses register

### Customer

- `GET /booking/{id}` - Form booking
- `POST /booking` - Proses booking
- `GET /booking/confirmation/{id}` - Konfirmasi booking

### Admin

- `GET /admin` - Dashboard
- `GET /admin/homestays` - Daftar homestay
- `POST /admin/homestays` - Tambah homestay
- `PUT /admin/homestays/{id}` - Update homestay
- `DELETE /admin/homestays/{id}` - Hapus homestay
- `GET /admin/bookings` - Daftar booking
- `PUT /admin/bookings/{id}/status` - Update status booking

## 🤝 Kontribusi

Silakan fork dan submit pull request untuk kontribusi.

## 📄 Lisensi

MIT License - Silakan gunakan untuk keperluan komersial maupun non-komersial.

## 📞 Support

Untuk pertanyaan atau saran, hubungi kami melalui:

- Email: support@adakamar.id
- Website: https://adakamar.id

---

**Made with ❤️ by AdaKamar Team**
