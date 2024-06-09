<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Office; // Import model Office untuk mengakses informasi kantor yang terkait dengan permintaan verifikasi

class OfficeVerificationRequestNotification extends Notification
{
    use Queueable;

    protected $office; // Menyimpan data kantor terkait dengan permintaan verifikasi

    /**
     * Create a new notification instance.
     *
     * @param Office $office
     */
    public function __construct(Office $office)
    {
        $this->office = $office;
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
                    ->subject('Office Verification Request')
                    ->line('A new office verification request has been submitted.')
                    ->line('Office Name: ' . $this->office->nama_kantor) // Menambahkan nama kantor ke pesan email
                    ->line('Description: ' . $this->office->description) // Menambahkan deskripsi kantor ke pesan email
                    ->action('View Request', url('/')) // Tautan untuk melihat permintaan (Anda bisa ganti dengan tautan yang sesuai)
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
            //
        ];
    }
}