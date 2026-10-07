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
        Schema::create('votes', function (Blueprint $table) {

            $table->id();

            // 回答ID
            $table->foreignId('answer_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 投票者
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->timestamps();

            // 同じ回答に同じユーザーが重複投票できないようにする
            $table->unique(['answer_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};