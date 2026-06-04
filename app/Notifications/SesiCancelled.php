<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\SesiKonseling;

class SesiCancelled extends Notification
{
    use Queueable;

    protected $sesi;
    protected $reason;

    public function __construct(SesiKonseling $sesi, $reason = null)
    {
        $this->sesi = $sesi;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = 'Sesi konsultasi Anda dibatalkan.';
        if ($this->sesi->payment_status === 'refunded') {
            $message .= ' Pembayaran akan dikembalikan.';
        }

        return [
            'message' => $message,
            'reason' => $this->reason,
            'payment_status' => $this->sesi->payment_status,
            'sesi_id' => $this->sesi->sesi_konseling_id ?? $this->sesi->id,
            'jadwal' => $this->sesi->jadwal,
        ];
    }
}
