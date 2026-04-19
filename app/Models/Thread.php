<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'is_anonymous'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'thread_likes');
    }

    public function saves()
    {
        return $this->belongsToMany(User::class, 'thread_saves');
    }

    public function replies()
    {
        return $this->hasMany(ThreadReply::class);
    }

    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('users.id', is_numeric($user) ? $user : $user->id)->exists();
    }

    public function isSavedBy($user)
    {
        if (!$user) return false;
        return $this->saves()->where('users.id', is_numeric($user) ? $user : $user->id)->exists();
    }
}
