<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'topic_id',
        'answer_id',
        'reason',
        'status',
    ];

    /**
     * 通報者
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * 通報対象ユーザー
     */
    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    /**
     * お題
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 回答
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}