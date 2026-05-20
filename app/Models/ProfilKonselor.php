<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilKonselor extends Model
{
    use HasFactory;

    protected $table = 'profil_konselor';
    protected $primaryKey = 'profil_konselor_id';

    protected $fillable = [
        'user_id',
        'nama',
        'spesialisasi',
        'biografi',
        'keahlian',
        'gejala',
        'nomor_whatsapp',
        'no_sipp',
        'berkas_ktp',
        'berkas_sipp',
        'berkas_cv',
        'harga_per_sesi',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('keahlian', 'like', "%{$search}%")
                ->orWhere('spesialisasi', 'like', "%{$search}%")
                ->orWhere('gejala', 'like', "%{$search}%");
        });
    }

    public function scopeFilterSpecialization($query, $spesialisasi)
    {
        return $query->where('spesialisasi', $spesialisasi);
    }

    public function scopeHasAvailability($query)
    {
        return $query->whereHas('sesiKonseling', fn ($q) => $q->where('status', '!=', 'penuh'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sesiKonseling()
    {
        return $this->hasMany(SesiKonseling::class, 'profil_konselor_id', 'profil_konselor_id');
    }

    public function counselorSchedules()
    {
        return $this->hasMany(CounselorSchedule::class, 'profil_konselor_id', 'profil_konselor_id');
    }
}
