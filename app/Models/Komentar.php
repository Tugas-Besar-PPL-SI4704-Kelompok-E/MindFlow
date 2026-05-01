<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentars';
    protected $primaryKey = 'komentar_id';
    public $timestamps = false;

    protected $fillable = [
        'forum_id',
        'user_id',
        'konten_komentar',
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

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id', 'forum_id');
    }
}
