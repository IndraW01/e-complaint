<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailPengaduan extends Notification
{
    use Queueable;

    protected $pengaduan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello, Admin')
            ->line('Pengadauan baru telah dibuat oleh: ' . $this->pengaduan->Tiket->Mahasiswa->name . ' dengan token: ' . $this->pengaduan->Tiket->token)
            ->line('Pengaduan dibuat ' . $this->pengaduan->created_at)
            ->action('Cek Pengaduan', route('pengaduan.show', $this->pengaduan))
            ->line('Terima Kasih');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
