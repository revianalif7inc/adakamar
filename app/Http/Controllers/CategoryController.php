<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Keep admin CRUD behind auth, but allow public access to listing and show
        $this->middleware('auth')->except(['publicIndex', 'show']);
    }

    public function index()
    {
        $categories = Category::orderBy('is_pinned', 'desc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'is_pinned' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer',
        ]);

        // allow custom slug; fallback to slugified name
        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        $validated['is_pinned'] = !empty($validated['is_pinned']);
        if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
            $validated['sort_order'] = Category::max('sort_order') + 1;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'is_pinned' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer',
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        $validated['is_pinned'] = !empty($validated['is_pinned']);
        if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
            $validated['sort_order'] = $category->sort_order ?? ($category->id);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->homestays()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Tidak bisa menghapus kategori yang masih digunakan');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }

    // Public listing for categories
    public function publicIndex()
    {
        $query = Category::withCount('homestays');

        // Only apply order by pinned/sort if columns exist (safe for DBs without migration applied)
        if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'is_pinned')) {
            $query = $query->orderBy('is_pinned', 'desc');
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('categories', 'sort_order')) {
            $query = $query->orderBy('sort_order', 'asc');
        }

        $categories = $query->orderBy('homestays_count', 'desc')->paginate(18);

        return view('pages.categories.index', compact('categories'));
    }

    // Show homestays under a category
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $homestays = $category->homestays()->where('is_active', true)
            ->with('owner', 'location', 'category')
            ->paginate(12);

        return view('pages.categories.show', compact('category', 'homestays'));
    }

    // Admin actions: toggle pin and move order
    public function togglePin(Category $category)
    {
        $category->is_pinned = !$category->is_pinned;
        $category->save();

        return back()->with('success', 'Pin kategori diperbarui');
    }

    public function move(Request $request, Category $category)
    {
        $direction = $request->input('direction'); // 'up' or 'down'
        if ($direction === 'up') {
            $swap = Category::where('sort_order', '<', $category->sort_order)
                ->orderBy('sort_order', 'desc')
                ->first();
        } else {
            $swap = Category::where('sort_order', '>', $category->sort_order)
                ->orderBy('sort_order', 'asc')
                ->first();
        }

        if ($swap) {
            $tmp = $swap->sort_order;
            $swap->sort_order = $category->sort_order;
            $category->sort_order = $tmp;
            $swap->save();
            $category->save();
        }

        return back()->with('success', 'Urutan kategori diperbarui');
    }
}
