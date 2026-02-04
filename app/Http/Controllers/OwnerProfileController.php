<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OwnerProfileController extends Controller
{
    /**
     * Display the owner's profile with their homestays
     */
    public function show($id)
    {
        // Get owner with homestays
        $owner = User::with([
            'homestays' => function ($query) {
                $query->where('is_active', true)->orderBy('created_at', 'desc');
            }
        ])
            ->where('role', 'owner')
            ->findOrFail($id);

        // Get homestays count, total price, etc.
        $homestaysCount = $owner->homestays->count();
        $averageRating = $owner->homestays->avg('rating') ?? 0;

        // Get locations from owner's homestays
        $locations = $owner->homestays->pluck('location')->unique();

        return view('pages.owner-profile', [
            'owner' => $owner,
            'homestays' => $owner->homestays,
            'homestaysCount' => $homestaysCount,
            'averageRating' => $averageRating,
            'locations' => $locations,
        ]);
    }
}
