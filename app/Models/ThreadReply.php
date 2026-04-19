<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreadReply extends Model
{
    protected $fillable = ['user_id', 'thread_id', 'parent_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function parent()
    {
        return $this->belongsTo(ThreadReply::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ThreadReply::class, 'parent_id');
    }

    public function reports()
    {
        return $this->hasMany(ReplyReport::class);
    }
}
