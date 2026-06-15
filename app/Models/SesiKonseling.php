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
        'approved_at',
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

        // 1. Batalkan sesi 'pending' yang tidak direspon konselor (Default 2 hari)
        $timeoutPending = env('AUTO_CANCEL_SECONDS', 172800);
        $expiredPendingSessions = self::where('status', 'pending')
            ->where('created_at', '<', now()->subSeconds($timeoutPending))
            ->with('profilKonselor')
            ->get();

        // 2. Batalkan sesi 'approved' yang tidak dibayar user dalam 24 jam
        $expiredApprovedSessions = self::where('status', 'approved')
            ->where('approved_at', '<', now()->subHours(24))
            ->with('profilKonselor')
            ->get();

        $allExpired = $expiredPendingSessions->concat($expiredApprovedSessions);
        $cancelledCount = $allExpired->count();

        if ($cancelledCount > 0) {
            foreach ($allExpired as $session) {
                $isPaid = ($session->payment_status === 'paid');
                $updateData = ['status' => 'system_cancelled'];
                if ($isPaid) {
                    $updateData['payment_status'] = 'refunded';
                }
                $session->update($updateData);
            }
        }

        $userId = \Illuminate\Support\Facades\Auth::id();
        if ($userId) {
            // Temukan sesi pending/approved milik user tersebut yang sudah lewat waktunya (jadwal terlampaui)
            $expiredSessions = self::where('user_id', $userId)
                ->whereIn('status', ['pending', 'approved'])
                ->where('jadwal', '<', now())
                ->with('profilKonselor')
                ->get();

            if ($expiredSessions->isNotEmpty()) {
                foreach ($expiredSessions as $session) {
                    $isPaid = ($session->payment_status === 'paid');
                    
                    $updateData = ['status' => 'cancelled'];
                    if ($isPaid) {
                        $updateData['payment_status'] = 'refunded';
                    }
                    $session->update($updateData);
                }
            }
        }

        // Batalkan seluruh sesi pending/approved lainnya yang sudah kadaluarsa secara umum
        self::whereIn('status', ['pending', 'approved'])
            ->where('jadwal', '<', now())
            ->update(['status' => 'cancelled']);

        // --- POPULATE NOTIFICATIONS FOR LOGGED IN USER (IMMUNE TO RACE CONDITIONS) ---
        if ($userId) {
            $seenSessionIds = session()->get('seen_cancelled_session_ids', []);

            // 1. Dapatkan semua sesi system_cancelled milik user ini yang belum pernah dilihat
            $unseenSystemCancelled = self::where('user_id', $userId)
                ->where('status', 'system_cancelled')
                ->whereNotIn('sesi_konseling_id', $seenSessionIds)
                ->with('profilKonselor')
                ->get();

            // 2. Dapatkan semua sesi cancelled (yang jadwalnya sudah lewat) milik user ini yang belum pernah dilihat
            $unseenCancelled = self::where('user_id', $userId)
                ->where('status', 'cancelled')
                ->where('jadwal', '<', now())
                ->whereNotIn('sesi_konseling_id', $seenSessionIds)
                ->with('profilKonselor')
                ->get();

            $allUnseen = $unseenSystemCancelled->concat($unseenCancelled);

            if ($allUnseen->isNotEmpty()) {
                $timeoutCancelledDetails = [];
                $refundDetails = [];

                foreach ($allUnseen as $session) {
                    $counselorName = $session->profilKonselor ? $session->profilKonselor->nama : 'Konselor';
                    $isPaid = ($session->payment_status === 'paid' || $session->payment_status === 'refunded');
                    
                    if ($session->status === 'system_cancelled') {
                        $reason = 'Tidak ada respons dari konselor selama 2 hari.';
                    } else {
                        $reason = 'Waktu jadwal telah terlampaui tanpa penyelesaian alur (Persetujuan/Pembayaran).';
                    }

                    if ($isPaid) {
                        $refundDetails[] = [
                            'sesi_konseling_id' => $session->sesi_konseling_id,
                            'jadwal' => \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M Y, H:i'),
                            'konselor' => $counselorName,
                            'reason' => $reason,
                        ];
                    } else {
                        $timeoutCancelledDetails[] = [
                            'sesi_konseling_id' => $session->sesi_konseling_id,
                            'jadwal' => \Carbon\Carbon::parse($session->jadwal)->translatedFormat('d M Y, H:i'),
                            'konselor' => $counselorName,
                            'reason' => $reason,
                        ];
                    }
                }

                if (!empty($timeoutCancelledDetails)) {
                    session()->put('expired_cancelled_sessions', $timeoutCancelledDetails);
                } else {
                    session()->forget('expired_cancelled_sessions');
                }
                if (!empty($refundDetails)) {
                    session()->put('refund_sessions', $refundDetails);
                } else {
                    session()->forget('refund_sessions');
                }
            } else {
                session()->forget('expired_cancelled_sessions');
                session()->forget('refund_sessions');
            }
        }

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
