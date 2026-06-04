<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKonseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesi_konseling_id',
        'pengirim_id',
        'isi_pesan',
    ];

    public function sesiKonseling()
    {
        return $this->belongsTo(SesiKonseling::class, 'sesi_konseling_id', 'sesi_konseling_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}
