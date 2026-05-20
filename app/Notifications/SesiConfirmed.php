<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\SesiKonseling;

class SesiConfirmed extends Notification
{
    use Queueable;

    protected $sesi;

    public function __construct(SesiKonseling $sesi)
    {
        $this->sesi = $sesi;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Sesi konsultasi Anda telah dikonfirmasi.',
            'sesi_id' => $this->sesi->sesi_konseling_id ?? $this->sesi->id,
            'profil_konselor_id' => $this->sesi->profil_konselor_id,
            'jadwal' => $this->sesi->jadwal,
        ];
    }
}
