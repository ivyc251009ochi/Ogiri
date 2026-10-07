<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
    'name',
    'host_user_id',
    'topic_id',
    'status',
];

    /**
     * ルーム作成者
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    /**
     * ルーム参加者
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'room_users',
            'room_id',
            'user_id'
        );
    }

    /**
 * ルーム内の回答
 */
public function answers()
{
    return $this->hasMany(RoomAnswer::class);
}

    /**
     * 得点一覧
     */
    public function scores()
    {
        return $this->hasMany(RoomScore::class);
    }
    /**
 * 参加者
 */
public function roomUsers()
{
    return $this->hasMany(RoomUser::class);
}
/**
 * 使用するお題
 */
public function topic()
{
    return $this->belongsTo(Topic::class);
}
    
}