<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'profil_konselor_id',
        'sesi_konseling_id',
        'amount',
        'type',
        'status',
        'bank_name',
        'account_number',
        'account_holder',
        'description',
    ];

    public function profilKonselor()
    {
        return $this->belongsTo(ProfilKonselor::class, 'profil_konselor_id', 'profil_konselor_id');
    }

    public function sesiKonseling()
    {
        return $this->belongsTo(SesiKonseling::class, 'sesi_konseling_id', 'sesi_konseling_id');
    }
}
