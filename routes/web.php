<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OwnerProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [PagesController::class, 'about'])->name('about');

// Debug route used in local/testing only
if (app()->environment('local', 'testing')) {
    Route::get('/__debug_kamar', function () {
        \Illuminate\Support\Facades\Log::info('debug_kamar invoked', ['path' => request()->path(), 'query' => request()->query()]);
        return response('debug-ok');
    });

    // Debug homestay images
    Route::get('/__debug_homestays', function () {
        $homestays = \App\Models\Homestay::limit(10)->get();
        $html = '<h1>Homestay Debug</h1><style>table{border-collapse:collapse} td{border:1px solid #ccc;padding:10px} .red{color:red;font-weight:bold} .green{color:green;font-weight:bold}</style>';
        $html .= '<table><tr><th>ID</th><th>Name</th><th>image_url in DB</th><th>File Exists</th><th>URL</th><th>Action</th></tr>';

        foreach ($homestays as $h) {
            $exists = $h->image_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($h->image_url) ? 'YES' : 'NO';
            $existsClass = $exists === 'YES' ? 'green' : 'red';
            $url = $h->image_url ? asset('storage/' . $h->image_url) : 'N/A';
            $link = $h->image_url ? "<a href=\"{$url}\" target=\"_blank\">View</a>" : 'N/A';
            $action = "<a href=\"/admin/kamar/{$h->id}/edit\">Edit</a>";
            $html .= "<tr><td>{$h->id}</td><td>{$h->name}</td><td><code>{$h->image_url}</code></td><td><span class=\"{$existsClass}\">{$exists}</span></td><td>{$link}</td><td>{$action}</td></tr>";
        }

        $html .= '</table>';
        return response($html)->header('Content-Type', 'text/html');
    });
}
Route::get('/kamar', [HomestayController::class, 'index'])->name('kamar.index');

// Reviews
Route::post('/kamar/{homestay}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('/kamar/{homestay}', [HomestayController::class, 'show'])->name('kamar.show');
// English aliases for compatibility with some views
Route::get('/homestays', [HomestayController::class, 'index'])->name('homestays.index');
Route::get('/homestays/{homestay}', [HomestayController::class, 'show'])->name('homestays.show');

// Articles
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::get('/artikel/kategori/{slug}', [ArticleController::class, 'category'])->name('artikel.category');

// Public categories
Route::get('/kategori', [\App\Http\Controllers\CategoryController::class, 'publicIndex'])->name('categories.index');
Route::get('/kategori/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

Route::middleware([\App\Http\Middleware\Authenticate::class])->group(function () {
    Route::get('/booking/{homestay}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

    // Customer: My Rooms (bookings) and simple payment flow
    Route::get('/kamar-saya', [BookingController::class, 'myRooms'])->name('booking.my_rooms');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/pay', [BookingController::class, 'payForm'])->name('booking.pay.form');
    Route::post('/booking/{booking}/pay', [BookingController::class, 'pay'])->name('booking.pay');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes - Protected by auth & admin middleware
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Kamar Management
    Route::resource('kamar', HomestayController::class)->except(['show']);
    Route::put('/kamar/{id}/feature', [HomestayController::class, 'toggleFeature'])->name('kamar.toggleFeature');

    // Also register English-named routes for compatibility with existing views
    Route::resource('homestays', HomestayController::class)->except(['show']);
    Route::put('/homestays/{id}/feature', [HomestayController::class, 'toggleFeature'])->name('homestays.toggleFeature');

    // Confirm owner-submitted homestay
    Route::put('/kamar/{id}/confirm', [HomestayController::class, 'confirm'])->name('kamar.confirm');

    // Booking Management
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
    Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Category & Location management
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['show']);
    Route::post('categories/{category}/toggle-pin', [\App\Http\Controllers\CategoryController::class, 'togglePin'])->name('categories.togglePin');
    Route::post('categories/{category}/move', [\App\Http\Controllers\CategoryController::class, 'move'])->name('categories.move');
    Route::resource('locations', \App\Http\Controllers\LocationController::class)->except(['show']);

    // Articles management
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    // Article Categories management
    Route::resource('article-categories', \App\Http\Controllers\Admin\ArticleCategoryController::class);

    // User management
    Route::resource('users', \App\Http\Controllers\AdminUserController::class)->except(['show', 'create', 'store']);

    // Reviews (admin management)
    Route::get('reviews', [\App\Http\Controllers\AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}/edit', [\App\Http\Controllers\AdminReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{id}', [\App\Http\Controllers\AdminReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{id}', [\App\Http\Controllers\AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // End admin group
});

// Owner routes
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\OwnerMiddleware::class])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/', [\App\Http\Controllers\OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kamar', \App\Http\Controllers\OwnerHomestayController::class)->except(['show']);

    // Owner booking management (confirm paid bookings)
    Route::get('/bookings', [\App\Http\Controllers\OwnerBookingController::class, 'index'])->name('bookings.index');
    Route::put('/bookings/{booking}/status', [\App\Http\Controllers\OwnerBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

// Owner Profile - Public (MUST be after protected owner routes to avoid conflicts)
Route::get('/owner/{id}', [OwnerProfileController::class, 'show'])->name('owner.profile');

// Test route for debugging (optional - remove in production)
Route::get('/test-owner-profile', function () {
    $owners = \App\Models\User::where('role', 'owner')->with('homestays')->get();
    return view('pages.test-owner-profile', ['owners' => $owners]);
})->name('test.owner-profile');
