<?php

namespace App\Notifications;

use App\Models\KlienChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KlienChatNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $klienChat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(KlienChat $klienChat)
    {
        $this->klienChat = $klienChat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pesan Klien Baru')
            ->line('Anda memiliki pesan klien baru.')
            ->line('Nama: ' . $this->klienChat->name)
            ->line('Email: ' . $this->klienChat->email)
            ->line('WhatsApp: ' . $this->klienChat->whatsapp)
            ->line('Keperluan: ' . $this->klienChat->keperluan)
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'name' => $this->klienChat->name,
            'email' => $this->klienChat->email,
            'whatsapp' => $this->klienChat->whatsapp,
            'keperluan' => $this->klienChat->keperluan,
        ];
    }
}
