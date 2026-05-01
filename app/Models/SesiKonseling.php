<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiKonseling extends Model
{
    // Nama tabel di database
    protected $table = 'sesi_konselings';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id', 
        'profil_konselor_id', 
        'jadwal', 
        'status'
    ];
}