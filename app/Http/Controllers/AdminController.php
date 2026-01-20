<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Homestay;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware - specific admin check in route
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $totalHomestays = Homestay::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        $totalCategories = Category::count();
        $totalLocations = Location::count();

        $recentCategories = Category::latest()->limit(5)->get();
        $recentLocations = Location::latest()->limit(5)->get();

        $recentBookings = Booking::with('user', 'homestay')
            ->latest()
            ->limit(5)
            ->get();

        // Include a small preview of the most recent homestays for quick admin review
        $recentHomestays = Homestay::with('owner')->latest()->limit(6)->get();

        // Recent users for quick access (include review counts)
        $recentUsers = \App\Models\User::withCount('reviews')->latest()->limit(6)->get();

        // Recent reviews (ratings) so admin can preview and manage
        $recentReviews = \App\Models\Review::with('user', 'homestay')->latest()->limit(6)->get();

        return view('admin.dashboard.index', compact(
            'totalHomestays',
            'totalBookings',
            'pendingBookings',
            'totalRevenue',
            'recentBookings',
            'recentHomestays',
            'totalCategories',
            'totalLocations',
            'recentCategories',
            'recentLocations',
            'recentUsers',
            'recentReviews'
        ));
    }
}
