<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class OwnerBookingController extends Controller
{
    // List bookings for homestays owned by the authenticated owner
    public function index()
    {
        $owner = auth()->user();
        if (!$owner || $owner->role !== 'owner') {
            abort(403);
        }

        $bookings = Booking::with('user', 'homestay')
            ->whereHas('homestay', function ($q) use ($owner) {
                $q->where('owner_id', $owner->id);
            })
            ->latest()
            ->paginate(15);

        return view('owner.bookings.index', compact('bookings'));
    }

    // Owner: update status for a booking that belongs to their homestay
    public function updateStatus(Request $request, $id)
    {
        $owner = auth()->user();
        if (!$owner || $owner->role !== 'owner') {
            abort(403);
        }

        $booking = Booking::with('homestay')->findOrFail($id);

        // ensure booking's homestay belongs to this owner
        if ($booking->homestay->owner_id !== $owner->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui');
    }
}
