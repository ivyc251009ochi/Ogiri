<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_answers', function (Blueprint $table) {

            // 回答形式
            $table->enum('answer_type', [
                'text',
                'drawing',
                'image'
            ])->default('text')->after('user_id');

            // アップロードした画像
            $table->string('image_path')->nullable()->after('content');

            // お絵描きデータ
            $table->string('drawing_path')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('room_answers', function (Blueprint $table) {
            $table->dropColumn([
                'answer_type',
                'image_path',
                'drawing_path',
            ]);
        });
    }
};