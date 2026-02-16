<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $homestays = Cache::remember('home:top_homestays', 300, function () {
            return Homestay::where('is_active', true)
                ->orderBy('rating', 'desc')
                ->limit(6)
                ->get();
        });

        // Featured homestays (admin-selected) - only query if column exists
        $featuredHomestays = Cache::remember('home:featured_homestays', 300, function () {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')) {
                return collect();
            }

            return Homestay::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('updated_at', 'desc')
                ->limit(6)
                ->get();
        });

        // Top-rated homestays in Jogja (try to use Location model if present)
        $jogjaTopHomestays = Cache::remember('home:jogja_top', 300, function () {
            $loc = \App\Models\Location::where('slug', 'yogyakarta')->orWhere('name', 'like', '%Yogyakarta%')->first();
            $q = Homestay::where('is_active', true)->orderBy('rating', 'desc');
            if ($loc) {
                $q->where('location_id', $loc->id);
            } else {
                $q->where('location', 'like', '%Yogyakarta%');
            }
            return $q->limit(6)->get();
        });

        // Top categories (by number of homestays)
        $categories = Cache::remember('home:categories', 300, function () {
            $query = Category::withCount('homestays');
            if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'is_pinned')) {
                $query = $query->orderBy('is_pinned', 'desc');
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'sort_order')) {
                $query = $query->orderBy('sort_order', 'asc');
            }
            return $query->orderBy('homestays_count', 'desc')
                ->limit(6)
                ->get();
        });

        // Recent / high-rated testimonials for homepage
        $testimonials = Cache::remember('home:testimonials', 300, function () {
            return Review::with('user', 'homestay')
                ->whereHas('homestay', function ($q) {
                    $q->where('is_active', true);
                })
                ->orderBy('rating', 'desc')
                ->limit(6)
                ->get();
        });

        // Load locations for homepage search select - all locations
        $allLocations = \App\Models\Location::orderBy('name')->get();

        // Top 5 locations by homestay count
        $topLocations = Cache::remember('home:top_locations', 300, function () {
            return \App\Models\Location::withCount('homestays')
                ->orderBy('homestays_count', 'desc')
                ->limit(5)
                ->get();
        });

        // Cheapest homestays (by effective price: prefer monthly then yearly)
        $cheapestHomestays = Cache::remember('home:cheapest_homestays', 300, function () {
            return Homestay::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNotNull('price_per_month')->orWhereNotNull('price_per_year');
                })
                ->orderByRaw('COALESCE(price_per_month, price_per_year) asc')
                ->limit(6)
                ->get();
        });

        return view('pages.home', compact('homestays', 'featuredHomestays', 'jogjaTopHomestays', 'categories', 'testimonials', 'allLocations', 'topLocations', 'cheapestHomestays'));
    }
}
