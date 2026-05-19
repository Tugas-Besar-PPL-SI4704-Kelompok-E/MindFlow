<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SesiKonseling;
use Carbon\Carbon;

class SessionAutoCancelled extends Notification
{
    use Queueable;

    public $session;

    /**
     * Create a new notification instance.
     */
    public function __construct(SesiKonseling $session)
    {
        $this->session = $session;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'sesi_konseling_id' => $this->session->sesi_konseling_id,
            'title' => 'Sesi Dibatalkan Otomatis',
            'message' => 'Sesi konseling Anda pada tanggal ' . Carbon::parse($this->session->jadwal)->translatedFormat('d F Y H:i') . ' dengan ' . ($this->session->profilKonselor->nama ?? 'Konselor') . ' telah dibatalkan otomatis karena melebihi 24 jam tanpa respons.',
        ];
    }
}
