<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\OwnerMiddleware::class]);
    }

    public function index()
    {
        $user = auth()->user();

        $totalHomestays = $user->homestays()->count();

        $homestayIds = $user->homestays()->pluck('id')->toArray();

        $totalBookings = Booking::whereIn('homestay_id', $homestayIds)->count();
        $pendingBookings = Booking::whereIn('homestay_id', $homestayIds)->where('status', 'pending')->count();
        $totalRevenue = Booking::whereIn('homestay_id', $homestayIds)->where('status', 'completed')->sum('total_price');

        $recentBookings = Booking::whereIn('homestay_id', $homestayIds)->latest()->limit(8)->get();

        $myHomestays = $user->homestays()->latest()->limit(6)->get();

        return view('owner.dashboard.index', compact('totalHomestays', 'totalBookings', 'pendingBookings', 'totalRevenue', 'recentBookings', 'myHomestays'));
    }
}
