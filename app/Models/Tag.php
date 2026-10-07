<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'name',
    ];

    /**
     * このタグが付いているお題
     */
    /**
 * お題（多対多）
 */
public function topics()
{
    return $this->belongsToMany(Topic::class, 'topic_tag');
}
}