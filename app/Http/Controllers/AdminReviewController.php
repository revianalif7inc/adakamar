<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Homestay;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $userId = $request->query('user_id');
        $homestayId = $request->query('homestay_id');
        $rating = $request->query('rating');

        $query = Review::with('user', 'homestay')->latest();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                })->orWhereHas('homestay', function ($h) use ($q) {
                    $h->where('name', 'like', "%{$q}%");
                })->orWhere('comment', 'like', "%{$q}%");
            });
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($homestayId) {
            $query->where('homestay_id', $homestayId);
        }

        if ($rating) {
            $query->where('rating', $rating);
        }

        $reviews = $query->paginate(20)->appends($request->except('page'));

        // For filter selects
        $users = \App\Models\User::orderBy('name')->get();
        $homestays = \App\Models\Homestay::orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'q', 'users', 'homestays'));
    }

    public function edit($id)
    {
        $review = Review::with('user', 'homestay')->findOrFail($id);
        $homestays = Homestay::orderBy('name')->get();
        return view('admin.reviews.edit', compact('review', 'homestays'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'homestay_id' => 'required|exists:homestays,id'
        ]);

        $review->update($data);

        // Recalculate homestay rating for the affected homestay(s)
        $this->recalcHomestayRating($data['homestay_id']);
        if ($review->homestay_id && $review->homestay_id != $data['homestay_id']) {
            $this->recalcHomestayRating($review->homestay_id);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan diperbarui.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $homestayId = $review->homestay_id;
        $review->delete();
        $this->recalcHomestayRating($homestayId);
        return redirect()->route('admin.reviews.index')->with('success', 'Ulasan dihapus.');
    }

    protected function recalcHomestayRating($homestayId)
    {
        $avg = Review::where('homestay_id', $homestayId)->avg('rating');
        $h = Homestay::find($homestayId);
        if ($h) {
            $h->rating = $avg ? round((float) $avg, 2) : null;
            $h->save();
        }
    }
}
