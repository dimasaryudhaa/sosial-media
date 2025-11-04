<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'body', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    /**
     * The user that owns the post.
     *
     * @return BelongsTo
     */
/******  5420a2f3-6a01-4f1d-b355-ca2df94f3f3c  *******/    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
