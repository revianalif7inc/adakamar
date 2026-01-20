<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::published()->orderBy('published_at', 'desc')->paginate(6);
        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function category($slug)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('article_categories')) {
            abort(404);
        }
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()->published()->orderBy('published_at', 'desc')->paginate(6);
        return view('articles.index', compact('articles', 'category'));
    }
}
