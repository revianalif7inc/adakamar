# Arsitektur AdaKamar

## Struktur Folder Aplikasi

### `/app/Services`
Berisi business logic dan service classes untuk menangani operasi kompleks.

**Contoh:**
- `HomestayService.php` - Logika untuk homestay
- `BookingService.php` - Logika untuk booking
- `PaymentService.php` - Integrasi pembayaran

### `/app/Repositories`
Berisi Repository pattern untuk abstraksi database queries.

**Contoh:**
- `HomestayRepository.php`
- `BookingRepository.php`
- `UserRepository.php`

### `/app/Traits`
Berisi shared functionality yang dapat digunakan di multiple classes.

**Contoh:**
- `HasSlug.php` - Trait untuk generate slug
- `HasTimestamps.php` - Custom timestamps

### `/app/Requests`
Berisi Form Request Validation classes.

**Contoh:**
- `StoreHomestayRequest.php`
- `StoreBookingRequest.php`
- `UpdateProfileRequest.php`

### `/app/Http/Controllers`
- Controller utama berisi base functionality
- Controllers terorganisir per fitur
- Admin controllers di folder `Admin/`

### `/routes`
- `web.php` - Web routes dengan grouping per role (public, auth, admin, owner)
- `api.php` - API routes (jika ada)
- `console.php` - Artisan commands

### `/resources/views`
- `auth/` - Authentication views
- `admin/` - Admin dashboard views
- `owner/` - Owner dashboard views
- `customer/` - Customer views
- `homestay/` - Homestay listing & detail views
- `articles/` - Blog articles
- `components/` - Reusable Blade components
- `layouts/` - Master layouts

### `/database`
- `migrations/` - Database structure changes (chronologically ordered)
- `seeders/` - Test data

### `/config`
- `app.php` - Application configuration
- `auth.php` - Authentication
- `database.php` - Database connection
- `cache.php` - Caching
- `session.php` - Session handling

## Best Practices

1. **Separation of Concerns** - Business logic di Services, database queries di Repositories
2. **Naming Convention** - Konsisten menggunakan singular/plural sesuai context
3. **Route Naming** - Menggunakan named routes untuk link generation
4. **Middleware** - Custom middleware untuk authorization (AdminMiddleware, OwnerMiddleware)
5. **Validation** - Menggunakan Form Request untuk validation

## Diagram Alur Request

```
HTTP Request
    ↓
Routes (web.php)
    ↓
Middleware (Auth, AdminMiddleware, OwnerMiddleware)
    ↓
Controller
    ↓
Service / Repository
    ↓
Model (Eloquent)
    ↓
Database
```
