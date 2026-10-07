<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'answer_id',
        'user_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomAnswer()
    {
        return $this->belongsTo(RoomAnswer::class, 'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}