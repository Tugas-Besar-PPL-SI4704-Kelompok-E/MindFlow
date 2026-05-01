<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';
    protected $primaryKey = 'forum_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'judul_thread',
        'konten',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'forum_id', 'forum_id');
    }

    public function laporans()
    {
        return $this->hasMany(LaporanForum::class, 'forum_id', 'forum_id');
    }
}
