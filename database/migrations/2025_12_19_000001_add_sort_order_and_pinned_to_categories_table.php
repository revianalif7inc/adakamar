<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('description');
            $table->boolean('is_pinned')->default(false)->after('sort_order');
        });

        // Initialize sort_order for existing records using id
        DB::table('categories')->orderBy('id')->get()->each(function ($c, $i) {
            DB::table('categories')->where('id', $c->id)->update(['sort_order' => $c->id]);
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'is_pinned']);
        });
    }
};