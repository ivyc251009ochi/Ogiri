<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'topic_type',
    'title',
    'description',
    'image_path',
    'image_source_type',
];

    /**
     * お題の投稿者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * お題に対する回答
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * タグ（多対多）
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'topic_tag');
    }

    /**
     * パーティーモードの回答
     */
    public function roomAnswers()
    {
        return $this->hasMany(RoomAnswer::class);
    }
    
}