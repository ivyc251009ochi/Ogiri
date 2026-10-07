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
        Schema::create('room_votes', function (Blueprint $table) {

            $table->id();

            // ルームID
            $table->foreignId('room_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 回答ID
            $table->foreignId('answer_id')
                  ->constrained('room_answers')
                  ->cascadeOnDelete();

            // 投票者
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();

            // 同じ回答に同じユーザーが複数回投票できないようにする
            $table->unique(['answer_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_votes');
    }
};