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
        Schema::create('reports', function (Blueprint $table) {

            $table->id();

            // 通報したユーザー
            $table->foreignId('reporter_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // 通報されたユーザー
            $table->foreignId('reported_user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // 通報理由
            $table->text('reason');

            // 対応状況
            $table->enum('status', [
                'pending',
                'resolved',
                'rejected'
            ])->default('pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};