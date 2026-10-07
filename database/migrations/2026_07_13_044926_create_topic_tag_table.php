<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('topic_tag', function (Blueprint $table) {

            $table->id();

            // お題ID
            $table->foreignId('topic_id')
                  ->constrained()
                  ->onDelete('cascade');

            // タグID
            $table->foreignId('tag_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->timestamps();

            // 同じタグを重複登録できないようにする
            $table->unique(['topic_id', 'tag_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_tag');
    }
};