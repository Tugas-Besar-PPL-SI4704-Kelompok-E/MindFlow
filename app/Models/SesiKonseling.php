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
        'payment_method',
        'payment_status',
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
     * Membatalkan sesi yang berstatus pending jika sudah melebihi batas waktu auto-cancel.
     */
    public static function cancelExpiredPendingSessions()
    {
        $timeout = env('AUTO_CANCEL_SECONDS', 3);

        return self::where('status', 'pending')
            ->where('created_at', '<', now()->subSeconds($timeout))
            ->update([
                'status' => 'system_cancelled',
                'payment_status' => 'refunded',
            ]);
    }
    public function scopeByTimeRange($query, $range)
    {
        if ($range === '1_month') {
            return $query->where('jadwal', '>=', now()->subMonth()->format('Y-m-d H:i:s'));
        } elseif ($range === '3_months') {
            return $query->where('jadwal', '>=', now()->subMonths(3)->format('Y-m-d H:i:s'));
        } elseif ($range === '6_months') {
            return $query->where('jadwal', '>=', now()->subMonths(6)->format('Y-m-d H:i:s'));
        } elseif ($range === '1_year') {
            return $query->where('jadwal', '>=', now()->subYear()->format('Y-m-d H:i:s'));
        }
        
        return $query;
    }
}
