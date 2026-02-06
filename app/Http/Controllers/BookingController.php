<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Homestay;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show booking form
    public function create($homestay_id)
    {
        $homestay = Homestay::findOrFail($homestay_id);
        return view('booking.create', compact('homestay'));
    }

    // Store booking
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'homestay_id' => 'required|exists:homestays,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'duration_unit' => 'required|in:month,year,night',
            'duration' => 'required|integer|min:1|max:120',
            'total_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_hp' => 'required|string|max:20',
        ]);

        $homestay = Homestay::findOrFail($validated['homestay_id']);

        $bookingDate = \Carbon\Carbon::parse($validated['booking_date']);

        // Pricing based on selected unit (month, year, night)
        $duration = (int) $validated['duration'];
        $unit = $validated['duration_unit'];
        $totalPrice = 0;
        $checkOutDate = null;

        if ($unit === 'month') {
            if (empty($homestay->price_per_month)) {
                return back()->withInput()->withErrors(['duration' => 'Homestay tidak memiliki harga bulanan.']);
            }
            $totalPrice = (float) $homestay->price_per_month * $duration;
            $checkOutDate = $bookingDate->copy()->addMonthsNoOverflow($duration)->toDateString();
        } elseif ($unit === 'year') {
            if (empty($homestay->price_per_year)) {
                return back()->withInput()->withErrors(['duration' => 'Homestay tidak memiliki harga tahunan.']);
            }
            $totalPrice = (float) $homestay->price_per_year * $duration;
            $checkOutDate = $bookingDate->copy()->addYears($duration)->toDateString();
        } else {
            // night/day pricing
            if (empty($homestay->price_per_night)) {
                return back()->withInput()->withErrors(['duration' => 'Homestay tidak memiliki harga harian.']);
            }
            $totalPrice = (float) $homestay->price_per_night * $duration;
            $checkOutDate = $bookingDate->copy()->addDays($duration)->toDateString();
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'homestay_id' => $validated['homestay_id'],
            'check_in_date' => $validated['booking_date'],
            'check_out_date' => $checkOutDate,
            'total_guests' => $validated['total_guests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nomor_hp' => $validated['nomor_hp'],
        ]);

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Booking berhasil dibuat');
    }

    // Show booking confirmation
    public function confirmation($id)
    {
        $booking = Booking::with('homestay', 'user')->findOrFail($id);

        // Only booking owner or admin can view confirmation
        if (auth()->id() !== $booking->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('booking.confirmation', compact('booking'));
    }

    // Customer: list user's bookings (kamar saya)
    public function myRooms()
    {
        $user = auth()->user();
        if ($user->role !== 'customer') {
            abort(403);
        }

        $bookings = Booking::with('homestay')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('customer.my_rooms', compact('bookings'));
    }

    // Show a simple payment form/confirmation (placeholder)
    public function payForm($id)
    {
        $booking = Booking::with('homestay')->findOrFail($id);
        if (auth()->id() !== $booking->user_id) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('info', 'Booking sudah dibayar atau tidak dapat dibayar.');
        }

        return view('booking.pay', compact('booking'));
    }

    // Show booking detail (for booking owner, homestay owner, and admins)
    public function show($id)
    {
        $booking = Booking::with('homestay.owner', 'user')->findOrFail($id);

        $user = auth()->user();
        $isBookingOwner = $user && $user->id === $booking->user_id;
        $isHomestayOwner = $user && $booking->homestay && $user->id === $booking->homestay->owner_id;
        $isAdmin = $user && method_exists($user, 'isAdmin') ? $user->isAdmin() : false;

        if (!($isBookingOwner || $isHomestayOwner || $isAdmin)) {
            abort(403);
        }

        return view('booking.show', compact('booking'));
    }

    // Process payment (placeholder - marks as confirmed)
    public function pay(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if (auth()->id() !== $booking->user_id) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('info', 'Booking sudah dibayar atau tidak dapat dibayar.');
        }

        // Mark as paid and wait for admin/owner confirmation
        $booking->status = 'paid';
        $booking->save();

        return redirect()->route('booking.my_rooms')->with('success', 'Pembayaran berhasil. Menunggu konfirmasi dari admin/owner.');
    }

    // Admin: List all bookings
    public function adminIndex()
    {
        $bookings = Booking::with('user', 'homestay')
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Admin: Update booking status
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,confirmed,cancelled,completed',
        ]);

        $booking->update($validated);

        return redirect()->back()
            ->with('success', 'Status booking berhasil diperbarui');
    }

    // Admin: Delete booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->back()
            ->with('success', 'Booking berhasil dihapus');
    }
}
