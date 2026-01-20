<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;

class ArticleCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_category_filtering()
    {
        $author = User::create(['name' => 'Auth', 'email' => 'a@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

        $cat1 = ArticleCategory::create(['name' => 'Tips', 'slug' => 'tips']);
        $cat2 = ArticleCategory::create(['name' => 'News', 'slug' => 'news']);

        $a1 = Article::create(['title' => 'First', 'slug' => 'first', 'body' => 'x', 'published_at' => now(), 'user_id' => $author->id]);
        $a2 = Article::create(['title' => 'Second', 'slug' => 'second', 'body' => 'y', 'published_at' => now(), 'user_id' => $author->id]);

        $a1->categories()->sync([$cat1->id]);
        $a2->categories()->sync([$cat2->id]);

        $respAll = $this->get('/artikel');
        $respAll->assertStatus(200);
        $respAll->assertSee('First');
        $respAll->assertSee('Second');

        $respCat = $this->get('/artikel/kategori/' . $cat1->slug);
        $respCat->assertStatus(200);
        $respCat->assertSee('First');
        $respCat->assertDontSee('Second');
    }

    public function test_admin_can_create_category()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admintest@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

        $resp = $this->actingAs($admin)->post(route('admin.article-categories.store'), ['name' => 'New Cat', 'slug' => 'new-cat']);

        $resp->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseHas('article_categories', ['slug' => 'new-cat', 'name' => 'New Cat']);
    }
}
