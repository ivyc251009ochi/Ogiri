<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * 一括代入を許可するカラム
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * 非表示にするカラム
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換
     *
     * @return array<string, string>
     */
    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

/**
 * 投稿したお題
 */
public function topics()
{
    return $this->hasMany(Topic::class);
}

    /**
     * ユーザーが作成したルーム
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'host_user_id');
    }

    /**
     * 管理者か判定
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * 利用停止中か判定
     */
    public function isSuspended()
    {
        return $this->status === 'suspended';
    }
}