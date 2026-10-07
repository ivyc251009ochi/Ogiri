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
        Schema::create('room_scores', function (Blueprint $table) {

            $table->id();

            // ルームID
            $table->foreignId('room_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // ユーザーID
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 得点
            $table->integer('score')->default(0);

            $table->timestamps();

            // 1ルームにつき1ユーザー1レコード
            $table->unique(['room_id', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_scores');
    }
};