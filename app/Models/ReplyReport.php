<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyReport extends Model
{
    protected $fillable = ['thread_reply_id', 'user_id', 'reason', 'status'];

    public function threadReply()
    {
        return $this->belongsTo(ThreadReply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
