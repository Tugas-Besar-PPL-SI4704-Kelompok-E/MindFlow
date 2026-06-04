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
     * Flag untuk mencegah eksekusi berulang dalam satu request.
     */
    protected static $hasCancelledExpired = false;

    /**
     * Membatalkan sesi yang berstatus pending jika waktunya sudah lewat (PBI-45)
     * ATAU jika sudah melebihi batas waktu auto-cancel (PBI-35).
     */
    public static function cancelExpiredPendingSessions($force = false)
    {
        if (self::$hasCancelledExpired && !$force) {
            return false;
        }
        self::$hasCancelledExpired = true;

        $userId = \Illuminate\Support\Facades\Auth::id();
        if ($userId) {
            // Temukan sesi pending milik user tersebut yang sudah lewat waktunya (kadaluarsa)
            $expiredSessions = self::where('user_id', $userId)
                ->where('status', 'pending')
                ->where('jadwal', '<', now())
                ->with('profilKonselor')
                ->get();

            if ($expiredSessions->isNotEmpty()) {
                // Batalkan sesi-sesi tersebut
                self::whereIn('sesi_konseling_id', $expiredSessions->pluck('sesi_konseling_id'))
                    ->update(['status' => 'cancelled']);

                // Kumpulkan informasi sesi untuk notifikasi
                $cancelledDetails = [];
                foreach ($expiredSessions as $session) {
                    $counselorName = $session->profilKonselor ? $session->profilKonselor->nama : 'Konselor';
                    $cancelledDetails[] = [
                        'jadwal' => \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M Y, H:i'),
                        'konselor' => $counselorName,
                    ];
                }

                // Simpan ke session untuk ditampilkan ke user (sampai ditutup secara manual)
                session()->put('expired_cancelled_sessions', $cancelledDetails);
            }
        }

        // Batalkan seluruh sesi pending lainnya yang sudah kadaluarsa secara umum
        self::where('status', 'pending')
            ->where('jadwal', '<', now())
            ->update(['status' => 'cancelled']);

        // Membatalkan sesi yang berstatus pending jika sudah melebihi batas waktu auto-cancel
        $timeout = env('AUTO_CANCEL_SECONDS', 3);

        $cancelledCount = self::where('status', 'pending')
            ->where('created_at', '<', now()->subSeconds($timeout))
            ->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded',
            ]);

        return $cancelledCount > 0;
    }
}
