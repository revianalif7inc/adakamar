<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        $categories = ArticleCategory::orderBy('name')->paginate(20);
        return view('admin.article_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.article_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories',
            'slug' => 'nullable|string|max:255|unique:article_categories,slug',
            'description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        ArticleCategory::create($validated);
        return redirect()->route('admin.article-categories.index')->with('success', 'Kategori artikel berhasil dibuat');
    }

    public function edit(ArticleCategory $articleCategory)
    {
        return view('admin.article_categories.edit', ['category' => $articleCategory]);
    }

    public function update(Request $request, ArticleCategory $articleCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name,' . $articleCategory->id,
            'slug' => 'nullable|string|max:255|unique:article_categories,slug,' . $articleCategory->id,
            'description' => 'nullable|string'
        ]);
        $validated['slug'] = Str::slug($validated['slug'] ?? $validated['name']);
        $articleCategory->update($validated);
        return redirect()->route('admin.article-categories.index')->with('success', 'Kategori artikel diperbarui');
    }

    public function destroy(ArticleCategory $articleCategory)
    {
        if ($articleCategory->articles()->exists()) {
            return back()->with('error', 'Kategori masih digunakan');
        }
        $articleCategory->delete();
        return back()->with('success', 'Kategori artikel dihapus');
    }
}
