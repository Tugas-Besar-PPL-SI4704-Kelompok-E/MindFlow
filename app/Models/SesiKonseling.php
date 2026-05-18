<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiKonseling extends Model
{
    use HasFactory;

    protected $table = 'sesi_konselings';
    protected $primaryKey = 'sesi_konseling_id';
    protected $fillable = [
        'user_id',
        'profil_konselor_id',
        'jadwal',
        'media_konseling',
        'deskripsi',
        'requested_jadwal',
        'request_reason',
        'status',
        'catatan_konselor',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profilKonselor()
    {
        return $this->belongsTo(ProfilKonselor::class, 'profil_konselor_id', 'profil_konselor_id');
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', '!=', 'penuh');
    }
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('jadwal', $date);
    }

    /**
     * Membatalkan sesi yang berstatus pending jika waktunya sudah lewat (PBI-45).
     */
    public static function cancelExpiredPendingSessions()
    {
        self::where('status', 'pending')
            ->where('jadwal', '<', now())
            ->update(['status' => 'cancelled']);
    }
}
