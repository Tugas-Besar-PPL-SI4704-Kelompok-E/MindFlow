<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKonselor extends Model
{
    protected $table = 'profil_konselors';
    protected $primaryKey = 'profil_konselor_id';

    protected $fillable = [
        'user_id',
        'nama',
        'spesialisasi',
        'biografi',
        'keahlian',
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
