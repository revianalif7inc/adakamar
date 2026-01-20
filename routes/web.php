<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomestayController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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

// Debug route used in local/testing only
if (app()->environment('local', 'testing')) {
    Route::get('/__debug_kamar', function () {
        \Illuminate\Support\Facades\Log::info('debug_kamar invoked', ['path' => request()->path(), 'query' => request()->query()]);
        return response('debug-ok');
    });
}
Route::get('/kamar', [HomestayController::class, 'index'])->name('kamar.index');

// Reviews
Route::post('/kamar/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('/kamar/{id}/{slug?}', [HomestayController::class, 'show'])->name('kamar.show');
// English aliases for compatibility with some views
Route::get('/homestays', [HomestayController::class, 'index'])->name('homestays.index');
Route::get('/homestays/{id}/{slug?}', [HomestayController::class, 'show'])->name('homestays.show');

// Articles
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('artikel.show');
Route::get('/artikel/kategori/{slug}', [ArticleController::class, 'category'])->name('artikel.category');

// Public categories
Route::get('/kategori', [\App\Http\Controllers\CategoryController::class, 'publicIndex'])->name('categories.index');
Route::get('/kategori/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

Route::middleware([\App\Http\Middleware\Authenticate::class])->group(function () {
    Route::get('/booking/{homestay_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{id}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

    // Customer: My Rooms (bookings) and simple payment flow
    Route::get('/kamar-saya', [BookingController::class, 'myRooms'])->name('booking.my_rooms');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{id}/pay', [BookingController::class, 'payForm'])->name('booking.pay.form');
    Route::post('/booking/{id}/pay', [BookingController::class, 'pay'])->name('booking.pay');
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
    Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

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
    Route::put('/bookings/{id}/status', [\App\Http\Controllers\OwnerBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});
