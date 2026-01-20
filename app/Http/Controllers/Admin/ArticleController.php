<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(6);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = \Illuminate\Support\Facades\Schema::hasTable('article_categories') ? ArticleCategory::orderBy('name')->get() : collect();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // If new category names were provided, create them and merge into categories[] before validation
        if ($request->filled('category_names')) {
            $names = array_filter(array_map('trim', preg_split('/,/', $request->input('category_names'))));
            $createdIds = [];
            foreach ($names as $name) {
                if ($name === '')
                    continue;
                // try case-insensitive find
                $cat = ArticleCategory::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
                if (!$cat) {
                    $cat = ArticleCategory::create(['name' => $name, 'slug' => Str::slug($name)]);
                }
                $createdIds[] = $cat->id;
            }
            $existing = $request->input('categories', []);
            $merged = array_values(array_unique(array_merge($existing, $createdIds)));
            $request->merge(['categories' => $merged]);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:article_categories,id',
        ]);

        $article = new Article($data);
        $article->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $article->image = $path;
        }

        if (empty($article->slug)) {
            $article->slug = $this->uniqueSlug($article->title);
        }

        $article->save();

        // sync categories if provided
        if ($request->filled('categories')) {
            $article->categories()->sync($request->input('categories'));
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat');
    }

    public function edit(Article $article)
    {
        $categories = \Illuminate\Support\Facades\Schema::hasTable('article_categories') ? ArticleCategory::orderBy('name')->get() : collect();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        // If new category names were provided, create them and merge into categories[] before validation
        if ($request->filled('category_names')) {
            $names = array_filter(array_map('trim', preg_split('/,/', $request->input('category_names'))));
            $createdIds = [];
            foreach ($names as $name) {
                if ($name === '')
                    continue;
                $cat = ArticleCategory::whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();
                if (!$cat) {
                    $cat = ArticleCategory::create(['name' => $name, 'slug' => Str::slug($name)]);
                }
                $createdIds[] = $cat->id;
            }
            $existing = $request->input('categories', []);
            $merged = array_values(array_unique(array_merge($existing, $createdIds)));
            $request->merge(['categories' => $merged]);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:article_categories,id',
        ]);

        $wasTitle = $article->title;
        $article->fill($data);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($article->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image);
            }
            $path = $request->file('image')->store('articles', 'public');
            $article->image = $path;
        }

        if ($wasTitle !== $article->title) {
            $article->slug = $this->uniqueSlug($article->title, $article->id);
        }

        $article->save();

        // sync categories if provided
        $article->categories()->sync($request->input('categories', []));

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy(Article $article)
    {
        if ($article->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    protected function uniqueSlug($title, $exceptId = null)
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (
            Article::where('slug', $slug)->when($exceptId, function ($q) use ($exceptId) {
                return $q->where('id', '!=', $exceptId);
            })->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
