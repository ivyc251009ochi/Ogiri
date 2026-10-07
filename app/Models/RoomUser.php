<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
    ];

    /**
     * ルーム
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * ユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}