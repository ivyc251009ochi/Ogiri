<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_answers', function (Blueprint $table) {
            $table->enum('answer_type', [
                'text',
                'drawing',
                'image'
            ])->default('text')->change();
        });
    }

    public function down(): void
    {
        Schema::table('room_answers', function (Blueprint $table) {
            $table->enum('answer_type', [
                'text',
                'drawing'
            ])->default('text')->change();
        });
    }
};