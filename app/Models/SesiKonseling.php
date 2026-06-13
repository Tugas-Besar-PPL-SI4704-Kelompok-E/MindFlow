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
        'payment_method',
        'payment_status',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'payment_channel',
        'xendit_payment_id',
        'payment_time',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profilKonselor()
    {
        return $this->belongsTo(ProfilKonselor::class, 'profil_konselor_id', 'profil_konselor_id');
    }
    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'jurnal_sesi_konseling', 'sesi_konseling_id', 'journal_id');
    }
    public function scopeAvailable($query)
    {
        return $query->where('status', '!=', 'penuh');
    }
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('jadwal', $date);
    }

    public function canEnterRoom()
    {
        if (!in_array($this->status, ['confirmed', 'rescheduled'])) {
            return false;
        }

        if ($this->payment_status !== 'paid') {
            return false;
        }

        $availableAt = \Carbon\Carbon::parse($this->jadwal)->subMinutes(15);
        return now()->gte($availableAt);
    }

    public function getRoomAccessMessage()
    {
        if (!in_array($this->status, ['confirmed', 'rescheduled'])) {
            return 'Sesi ini belum dikonfirmasi oleh konselor.';
        }

        if ($this->payment_status !== 'paid') {
            return 'Pembayaran belum selesai. Silakan selesaikan pembayaran terlebih dahulu.';
        }

        $availableAt = \Carbon\Carbon::parse($this->jadwal)->subMinutes(15);
        if (now()->lt($availableAt)) {
            return 'Ruangan dapat diakses mulai 15 menit sebelum jadwal dimulai.';
        }

        return 'Sesi sudah dapat diakses sekarang.';
    }

    /**
     * Flag untuk mencegah eksekusi berulang dalam satu request.
     */
    protected static $hasCancelledExpired = false;

    public static function cancelExpiredPendingSessions($force = false)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('sesi_konselings')) {
            return 0;
        }
        if (self::$hasCancelledExpired && !$force && !app()->runningUnitTests()) {
            return 0;
        }
        self::$hasCancelledExpired = true;

        $timeout = env('AUTO_CANCEL_SECONDS', 172800);

        $expiredTimeoutSessions = self::where('status', 'pending')
            ->where('created_at', '<', now()->subSeconds($timeout))
            ->with('profilKonselor')
            ->get();

        $cancelledCount = $expiredTimeoutSessions->count();

        if ($cancelledCount > 0) {
            $userId = \Illuminate\Support\Facades\Auth::id();
            $timeoutCancelledDetails = [];

            foreach ($expiredTimeoutSessions as $session) {
                $session->update([
                    'status' => 'system_cancelled',
                    'payment_status' => 'refunded',
                ]);
                if ($userId && $session->user_id === $userId) {
                    $counselorName = $session->profilKonselor ? $session->profilKonselor->nama : 'Konselor';
                    $timeoutCancelledDetails[] = [
                        'jadwal' => \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M Y, H:i'),
                        'konselor' => $counselorName,
                        'reason' => 'Tidak ada respons dari konselor selama 2 hari.',
                    ];
                }
            }

            if (!empty($timeoutCancelledDetails)) {
                $existing = session()->get('expired_cancelled_sessions', []);
                session()->put('expired_cancelled_sessions', array_merge($existing, $timeoutCancelledDetails));
            }
        }

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
                        'reason' => 'Tidak ada respons dari konselor hingga waktu yang dijadwalkan.',
                    ];
                }

                // Simpan ke session untuk ditampilkan ke user (sampai ditutup secara manual)
                $existing = session()->get('expired_cancelled_sessions', []);
                session()->put('expired_cancelled_sessions', array_merge($existing, $cancelledDetails));
            }
        }

        // Batalkan seluruh sesi pending lainnya yang sudah kadaluarsa secara umum
        self::where('status', 'pending')
            ->where('jadwal', '<', now())
            ->update(['status' => 'cancelled']);

        return $cancelledCount;
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
