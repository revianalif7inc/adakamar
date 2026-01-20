<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_article_category');
    }
}
