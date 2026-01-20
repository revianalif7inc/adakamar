<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomestayController extends Controller
{
    // Display listing of homestays
    public function index(Request $request)
    {
        // If accessed via admin routes, show admin management list (all homestays)
        if (request()->route() && request()->route()->named('admin.kamar.index')) {
            $q = $request->query('q');
            $category = $request->query('category');
            $location = $request->query('location_id');
            $status = $request->query('status');

            $query = Homestay::with('owner', 'categories', 'category', 'location');

            if ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            }

            if ($category) {
                $query->whereHas('categories', function ($q) use ($category) {
                    $q->where('id', $category);
                });
            }

            if ($location) {
                $query->where('location_id', $location);
            }

            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }

            $homestays = $query->orderBy('created_at', 'desc')
                ->paginate(20)
                ->appends($request->except('page'));

            $categories = Category::orderBy('sort_order', 'asc')->get();
            $locations = Location::orderBy('name')->get();

            return view('admin.homestays.index', compact('homestays', 'q', 'category', 'location', 'status', 'categories', 'locations'));
        }

        // Log incoming requests (test instrumentation)
        Log::info('HomestayController@index called', ['route_name' => request()->route()?->getName(), 'query' => request()->query()]);

        // Public listing only shows active homestays. Eager-load owner for display.
        $filters = request()->only(['search', 'category', 'location_id', 'min_price', 'max_price', 'sort']);

        $query = Homestay::with('owner', 'categories', 'category', 'location')
            ->where('is_active', true)
            ->filter($filters);

        $homestays = $query->paginate(12)->appends(request()->except('page'));

        // Also load categories with counts so the Kamar listing can show category filters
        $categories = Category::withCount('homestays')->orderBy('sort_order', 'asc')->get();
        $locations = Location::orderBy('name')->get();

        return view('pages.kamar', compact('homestays', 'categories', 'locations'));
    }

    // Show single homestay detail
    public function show($id)
    {
        $slug = request()->route('slug');
        $homestay = Homestay::with('owner', 'category', 'location')->findOrFail($id);

        // Redirect to canonical URL only if slug is provided but doesn't match
        if ($slug && $homestay->slug && $slug !== $homestay->slug) {
            return redirect()->route('kamar.show', ['id' => $homestay->id, 'slug' => $homestay->slug], 301);
        }

        $reviews = $homestay->reviews()->latest()->get();
        $userReview = auth()->check() ? $homestay->reviews()->where('user_id', auth()->id())->first() : null;

        return view('homestay.detail', compact('homestay', 'reviews', 'userReview'));
    }

    // Admin: Show form to create new homestay
    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.homestays.create', compact('categories', 'locations'));
    }

    // Admin: Store new homestay
    public function store(Request $request)
    {
        // If typed category_name is provided, find or create it and add its id to categories[]
        if ($request->filled('category_name')) {
            $name = trim($request->input('category_name'));
            if ($name !== '') {
                $cat = Category::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
                if (!$cat) {
                    $cat = Category::create(['name' => $name, 'slug' => \Illuminate\Support\Str::slug($name)]);
                }
                $ids = $request->input('categories', []);
                $ids[] = $cat->id;
                $request->merge(['categories' => array_values(array_unique($ids))]);
            }
        }

        // Backwards-compat: support single 'category_id' coming from older forms
        if ($request->filled('category_id') && !$request->filled('categories')) {
            $request->merge(['categories' => [$request->input('category_id')]]);
        }

        // Ensure 'Kost' category is always included
        $kost = Category::firstOrCreate(['slug' => 'kost'], ['name' => 'Kost', 'description' => null, 'sort_order' => 999, 'is_pinned' => false]);
        $ids = $request->input('categories', []);
        $ids[] = $kost->id;
        $request->merge(['categories' => array_values(array_unique($ids))]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|alpha_dash|unique:homestays,slug',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'address' => 'required|string|max:500',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'nullable|numeric|min:0',
            'price_per_month' => 'nullable|numeric|min:0',
            'price_per_year' => 'nullable|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'amenities' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // handle multiple uploaded images (admin create form may include images[] in the future)
        $extraImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('homestays', 'public');
                    if ($path) $extraImages[] = $path;
                }
            }
        }
        if (!empty($extraImages)) {
            $validated['images'] = $extraImages;
            // if no image_url provided, use the first uploaded image as primary
            if (empty($validated['image_url'])) {
                $validated['image_url'] = $extraImages[0];
            }
        }

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            if (!$file->isValid()) {
                return back()->withErrors(['image_url' => 'File gambar tidak valid atau gagal diunggah.'])->withInput();
            }
            $path = $file->store('homestays', 'public');
            if ($path) {
                $validated['image_url'] = $path;
            }
        }

        // Convert amenities string to array
        if (isset($validated['amenities']) && is_string($validated['amenities'])) {
            $validated['amenities'] = array_map('trim', explode(',', $validated['amenities']));
        }

        // Map address field to homestay 'location' column for display/address
        if (isset($validated['address'])) {
            $validated['location'] = $validated['address'];
            unset($validated['address']);
        }

        $validated['owner_id'] = auth()->id();

        // Only set is_featured if the column exists (defensive: migration may not have run yet)
        if (\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')) {
            $validated['is_featured'] = (bool) ($request->input('is_featured') ?? false);
        }

        // If the creator is an owner, set inactive and await admin confirmation
        if (auth()->user() && auth()->user()->isOwner()) {
            $validated['is_active'] = false;
        } else {
            $validated['is_active'] = true;
        }

        $homestay = Homestay::create($validated);

        // Sync categories (many-to-many) and keep a primary category_id for backward compatibility
        if (isset($validated['categories'])) {
            $homestay->categories()->sync($validated['categories']);
            $homestay->category_id = $validated['categories'][0] ?? null;
            $homestay->save();
        }

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan');
    }

    // Admin: Show form to edit homestay
    public function edit($id)
    {
        $homestay = Homestay::findOrFail($id);
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.homestays.edit', compact('homestay', 'categories', 'locations'));
    }

    // Admin: Update homestay
    public function update(Request $request, $id)
    {
        $homestay = Homestay::findOrFail($id);

        // If typed category_name is provided, find or create it and add its id to categories[]
        if ($request->filled('category_name')) {
            $name = trim($request->input('category_name'));
            if ($name !== '') {
                $cat = Category::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
                if (!$cat) {
                    $cat = Category::create(['name' => $name, 'slug' => \Illuminate\Support\Str::slug($name)]);
                }
                $ids = $request->input('categories', []);
                $ids[] = $cat->id;
                $request->merge(['categories' => array_values(array_unique($ids))]);
            }
        }

        // Backwards-compat: support single 'category_id' coming from older forms
        if ($request->filled('category_id') && !$request->filled('categories')) {
            $request->merge(['categories' => [$request->input('category_id')]]);
        }

        // Ensure 'Kost' category is always included
        $kost = Category::firstOrCreate(['slug' => 'kost'], ['name' => 'Kost', 'description' => null, 'sort_order' => 999, 'is_pinned' => false]);
        $ids = $request->input('categories', []);
        $ids[] = $kost->id;
        $request->merge(['categories' => array_values(array_unique($ids))]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|alpha_dash|unique:homestays,slug,' . $id,
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'address' => 'required|string|max:500',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'nullable|numeric|min:0',
            'price_per_month' => 'nullable|numeric|min:0',
            'price_per_year' => 'nullable|numeric|min:0',
            'max_guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'amenities' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // Merge existing images and newly uploaded ones if any
        $existing = $homestay->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('homestays', 'public');
                    if ($path) $existing[] = $path;
                }
            }
        }

        // allow removing images via remove_images[]
        if ($request->filled('remove_images')) {
            $toRemove = (array) $request->input('remove_images');
            foreach ($toRemove as $p) {
                try { \Illuminate\Support\Facades\Storage::disk('public')->delete($p); } catch (\Throwable $e) {}
                $existing = array_values(array_diff($existing, [$p]));
            }
        }
        $validated['images'] = array_values(array_unique($existing));

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            if (!$file->isValid()) {
                return back()->withErrors(['image_url' => 'File gambar tidak valid atau gagal diunggah.'])->withInput();
            }
            $path = $file->store('homestays', 'public');
            if ($path) {
                $validated['image_url'] = $path;
            }
        }

        // Convert amenities string to array
        if (isset($validated['amenities']) && is_string($validated['amenities'])) {
            $validated['amenities'] = array_map('trim', explode(',', $validated['amenities']));
        }

        if (isset($validated['address'])) {
            $validated['location'] = $validated['address'];
            unset($validated['address']);
        }

        $homestay->update($validated);

        // If checkbox omitted and column exists, ensure is_featured is false
        if (\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured') && !$request->has('is_featured')) {
            $homestay->is_featured = false;
            $homestay->save();
        }

        if (isset($validated['categories'])) {
            $homestay->categories()->sync($validated['categories']);
            $homestay->category_id = $validated['categories'][0] ?? null;
            $homestay->save();
        }

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui');
    }

    // Admin: Delete homestay
    public function destroy($id)
    {
        $homestay = Homestay::findOrFail($id);
        $homestay->delete();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus');
    }

    // Admin: confirm (approve) owner-submitted homestay
    public function confirm($id)
    {
        $homestay = Homestay::findOrFail($id);
        $homestay->is_active = true;
        $homestay->save();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dikonfirmasi dan sekarang tampil di publik.');
    }

    // Admin: toggle featured status
    public function toggleFeature($id)
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')) {
            return redirect()->route('admin.kamar.index')
                ->with('error', 'Kolom fitur belum ada. Jalankan migrasi untuk mengaktifkan fitur ini.');
        }

        $homestay = Homestay::findOrFail($id);
        $homestay->is_featured = !$homestay->is_featured;
        $homestay->save();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Status fitur kamar berhasil diperbarui');
    }
}
