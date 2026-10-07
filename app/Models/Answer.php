<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
    'topic_id',
    'user_id',
    'answer_type',
    'content',
    'image_path',
    'drawing_path',
    'description',
];
    /**
     * 回答したユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 回答先のお題
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 回答への投票
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * 投票数
     */
    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function voteCount()
    {
        return $this->votes()->count();
    }
}