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
        Schema::create('rooms', function (Blueprint $table) {

            // ルームID
            $table->id();

            // ルーム名
            $table->string('name');

            // ホストユーザー
            $table->foreignId('host_user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // 使用するお題
            $table->foreignId('topic_id')
                  ->nullable()
                  ->constrained('topics')
                  ->nullOnDelete();

            // ルーム状態
            $table->string('status')
                  ->default('waiting');

            // 作成日時・更新日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};