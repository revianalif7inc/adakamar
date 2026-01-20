<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\ArticleCategory;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $author = User::first();

        Article::firstOrCreate([
            'slug' => 'panduan-menjadi-host-yang-sukses'
        ], [
            'title' => 'Panduan Menjadi Host yang Sukses',
            'excerpt' => 'Tips praktis untuk pemilik homestay yang ingin meningkatkan pemesanan dan ulasan positif.',
            'body' => "Ini adalah contoh artikel. Isi artikel ini dengan panduan, tips, dan informasi berguna untuk host.",
            'published_at' => now(),
            'user_id' => $author ? $author->id : null,
        ]);

        Article::firstOrCreate([
            'slug' => 'cara-memilih-homestay-yang-tepat'
        ], [
            'title' => 'Cara Memilih Homestay yang Tepat',
            'excerpt' => 'Ketahui faktor penting saat memilih homestay untuk liburan Anda.',
            'body' => "Ini adalah artikel contoh tentang bagaimana memilih homestay yang sesuai kebutuhan Anda.",
            'published_at' => now(),
            'user_id' => $author ? $author->id : null,
        ]);

        // Create some categories
        $tips = ArticleCategory::firstOrCreate(['slug' => 'tips'], ['name' => 'Tips', 'description' => 'Tips dan trik']);
        $panduan = ArticleCategory::firstOrCreate(['slug' => 'panduan'], ['name' => 'Panduan', 'description' => 'Panduan untuk host']);
        $berita = ArticleCategory::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita', 'description' => 'Berita dan update']);

        // Example article with image
        $article = Article::firstOrCreate([
            'slug' => 'contoh-artikel-dengan-gambar'
        ], [
            'title' => 'Contoh Artikel dengan Gambar',
            'excerpt' => 'Contoh artikel yang menampilkan gambar pada card dan halaman detail.',
            'body' => "Artikel contoh ini memiliki gambar yang ditampilkan pada daftar artikel dan halaman detail.",
            'image' => 'articles/sample-article-1.svg',
            'published_at' => now(),
            'user_id' => $author ? $author->id : null,
        ]);

        // attach categories to example article
        if ($article && $article->exists) {
            $article->categories()->sync([$tips->id, $panduan->id]);
        }
    }
}
