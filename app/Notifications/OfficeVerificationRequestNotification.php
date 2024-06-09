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
    protected $token;  // Menyimpan token verifikasi

    /**
     * Create a new notification instance.
     *
     * @param Office $office
     * @param string $token
     */
    public function __construct(Office $office, string $token)
    {
        $this->office = $office;
        $this->token = $token;
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
        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/";
        } else {
            // Application is running on the server
            $url = "https://bilikhukum.com/";
        }

        $verificationUrl = $url . 'bisnis/office/verify?token=' . $this->token . '&user_id=' . $this->office->user_id . '&office_id=' . $this->office->id;

        return (new MailMessage)
                    ->subject('Office Verification Request')
                    ->line('A new office verification request has been submitted.')
                    ->line('Office Name: ' . $this->office->nama_kantor) // Menambahkan nama kantor ke pesan email
                    ->line('Description: ' . $this->office->description) // Menambahkan deskripsi kantor ke pesan email
                    ->action('View Request', $verificationUrl) // Tautan untuk melihat permintaan (Anda bisa ganti dengan tautan yang sesuai)
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
