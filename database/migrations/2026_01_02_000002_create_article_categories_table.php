<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('article_article_category', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_category_id')->constrained('article_categories')->onDelete('cascade');
            $table->primary(['article_id', 'article_category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_article_category');
        Schema::dropIfExists('article_categories');
    }
};