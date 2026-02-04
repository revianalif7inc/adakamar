<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class OwnerHomestayController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\OwnerMiddleware::class]);
    }

    public function index(Request $request)
    {
        $q = $request->query('q');
        $category = $request->query('category');
        $location = $request->query('location_id');
        $status = $request->query('status');

        $query = auth()->user()->homestays();

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
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

        $homestays = $query->latest()
            ->paginate(12)
            ->appends($request->except('page'));

        $categories = Category::orderBy('sort_order', 'asc')->get();
        $locations = Location::orderBy('name')->get();

        return view('owner.homestays.index', compact('homestays', 'q', 'category', 'location', 'status', 'categories', 'locations'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('owner.homestays.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        // If owner typed a new category name, create/find it and add to categories[]
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

        // Ensure 'Kost' category is always included for owners
        $kost = Category::firstOrCreate(['slug' => 'kost'], ['name' => 'Kost', 'description' => null, 'sort_order' => 999, 'is_pinned' => false]);
        $ids = $request->input('categories', []);
        $ids[] = $kost->id;
        $request->merge(['categories' => array_values(array_unique($ids))]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
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

        // If column exists, respect is_featured checkbox
        if (\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')) {
            $validated['is_featured'] = (bool) ($request->input('is_featured') ?? false);
        }

        // handle multiple images uploaded via name="images[]"
        $extraImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('homestays', 'public');
                    if ($path)
                        $extraImages[] = $path;
                }
            }
        }
        if (!empty($extraImages)) {
            $validated['images'] = $extraImages;
            // if owner didn't upload a separate cover image, use first extra image as cover
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

        if (isset($validated['amenities']) && is_string($validated['amenities'])) {
            $validated['amenities'] = array_map('trim', explode(',', $validated['amenities']));
        }

        if (isset($validated['address'])) {
            $validated['location'] = $validated['address'];
            unset($validated['address']);
        }

        $validated['owner_id'] = auth()->id();
        $validated['is_active'] = false; // must be confirmed by admin

        $homestay = Homestay::create($validated);

        if (isset($validated['categories'])) {
            $homestay->categories()->sync($validated['categories']);
            $homestay->category_id = $validated['categories'][0] ?? null;
            $homestay->save();
        }

        return redirect()->route('owner.kamar.index')->with('success', 'Kamar telah dibuat dan menunggu konfirmasi admin.');
    }

    public function edit($id)
    {
        $homestay = auth()->user()->homestays()->findOrFail($id);
        $categories = Category::all();
        $locations = Location::all();
        return view('owner.homestays.edit', compact('homestay', 'categories', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $homestay = auth()->user()->homestays()->findOrFail($id);

        // If owner typed a new category name, create/find it and add to categories[]
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

        // Ensure 'Kost' category is always included for owners
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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'amenities' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // If column exists, respect is_featured checkbox
        if (\Illuminate\Support\Facades\Schema::hasColumn('homestays', 'is_featured')) {
            $validated['is_featured'] = (bool) ($request->input('is_featured') ?? false);
        }

        // Merge newly uploaded images with existing ones
        $existing = $homestay->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('homestays', 'public');
                    if ($path)
                        $existing[] = $path;
                }
            }
        }

        // Handle image removals from edit form
        if ($request->filled('remove_images')) {
            $toRemove = (array) $request->input('remove_images');
            foreach ($toRemove as $p) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($p);
                } catch (\Throwable $e) {
                }
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

        if (isset($validated['amenities']) && is_string($validated['amenities'])) {
            $validated['amenities'] = array_map('trim', explode(',', $validated['amenities']));
        }

        if (isset($validated['address'])) {
            $validated['location'] = $validated['address'];
            unset($validated['address']);
        }

        // Keep is_active false until admin confirms again
        $validated['is_active'] = false;

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

        return redirect()->route('owner.kamar.index')->with('success', 'Kamar diperbarui dan menunggu konfirmasi admin.');
    }

    public function destroy($id)
    {
        $homestay = auth()->user()->homestays()->findOrFail($id);
        $homestay->delete();
        return redirect()->route('owner.kamar.index')->with('success', 'Kamar berhasil dihapus');
    }
}
