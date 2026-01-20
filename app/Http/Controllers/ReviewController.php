<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $homestayId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Anda harus masuk untuk memberi ulasan.');
        }

        $homestay = Homestay::findOrFail($homestayId);

        // Check if user has at least one confirmed or completed booking for this homestay
        $hasBooking = $user->bookings()->where('homestay_id', $homestay->id)->whereIn('status', ['confirmed', 'completed'])->exists();
        if (!$hasBooking) {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan setelah melakukan booking (dan dikonfirmasi / selesai).');
        }

        // Upsert review (one review per user per homestay)
        $review = Review::updateOrCreate(
            ['user_id' => $user->id, 'homestay_id' => $homestay->id],
            ['rating' => $request->input('rating'), 'comment' => $request->input('comment')]
        );

        // Recalculate average rating for the homestay
        $avg = Review::where('homestay_id', $homestay->id)->avg('rating');
        $homestay->rating = round((float) $avg, 2);
        $homestay->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'rating' => $homestay->rating, 'review' => $review]);
        }

        return redirect()->back()->with('success', 'Terima kasih. Ulasan Anda telah disimpan.');
    }
}
