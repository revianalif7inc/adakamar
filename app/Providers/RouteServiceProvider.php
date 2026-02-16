<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Bind 'homestay' and 'booking' route parameters so they resolve
        // by `slug` or fall back to numeric `id` for backward compatibility.
        Route::bind('homestay', function ($value) {
            $model = \App\Models\Homestay::where('slug', $value)->first();
            if ($model) {
                return $model;
            }
            if (is_numeric($value)) {
                return \App\Models\Homestay::findOrFail($value);
            }
            abort(404);
        });

        Route::bind('booking', function ($value) {
            $model = \App\Models\Booking::where('slug', $value)->first();
            if ($model) {
                return $model;
            }
            if (is_numeric($value)) {
                return \App\Models\Booking::findOrFail($value);
            }
            abort(404);
        });

        parent::boot(); // ← WAJIB ADA

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
