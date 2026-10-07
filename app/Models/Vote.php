<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'answer_id',
        'user_id',
    ];

    /**
     * 投票したユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 投票先の回答
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}