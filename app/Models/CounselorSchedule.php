<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselorSchedule extends Model
{
    protected $table = 'counselor_schedules';
    protected $primaryKey = 'counselor_schedule_id';
    protected $fillable = [
        'profil_konselor_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'is_active',
    ];

    public function profilKonselor()
    {
        return $this->belongsTo(ProfilKonselor::class, 'profil_konselor_id', 'profil_konselor_id');
    }
}
