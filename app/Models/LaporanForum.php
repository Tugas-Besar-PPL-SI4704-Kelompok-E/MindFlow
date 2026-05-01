<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanForum extends Model
{
    protected $table = 'laporan_forums';
    protected $primaryKey = 'laporan_forum_id';
    public $timestamps = false;

    protected $fillable = [
        'forum_id',
        'pelapor_id',
        'alasan_laporan',
        'status_tindak_lanjut',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id', 'forum_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
