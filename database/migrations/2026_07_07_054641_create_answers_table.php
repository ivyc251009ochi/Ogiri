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
        Schema::create('answers', function (Blueprint $table) {

            $table->id();

            // お題ID
            $table->foreignId('topic_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 回答者
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 回答タイプ
            $table->enum('answer_type', [
                'text',
                'drawing'
            ]);

            // テキスト回答
            $table->text('content')->nullable();

            // 手書きイラスト
            $table->string('drawing_path')->nullable();

            // 補足説明（任意）
            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};