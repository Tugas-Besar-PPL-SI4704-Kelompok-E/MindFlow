<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKonselor extends Model
{
    protected $table = 'profil_konselor';
    protected $primaryKey = 'profil_konselor_id';

    protected $fillable = [
        'user_id',
        'nama',
        'spesialisasi',
        'biografi',
        'keahlian',
        'nomor_whatsapp',
        'no_sipp',
        'berkas_ktp',
        'berkas_sipp',
        'berkas_cv',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sesiKonseling()
    {
        return $this->hasMany(SesiKonseling::class, 'profil_konselor_id', 'profil_konselor_id');
    }
}
