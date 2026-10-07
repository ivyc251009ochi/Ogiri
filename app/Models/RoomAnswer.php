<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'topic_id',
        'user_id',
        'answer_type',
        'content',
        'image_path',
        'drawing_path',
        'description',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(RoomVote::class, 'answer_id');
    }
}