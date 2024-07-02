<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $url;
    protected $encryptedParams;

    public function __construct($name, $url, $encryptedParams)
    {
        $this->name = $name;
        $this->url = $url;
        $this->encryptedParams = $encryptedParams;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello ' . $this->name . '!')
                    ->line('Please verify your email by clicking the button below.')
                    ->action('Verify Email', url($this->url . $this->encryptedParams))
                    ->line('Thank you for using our application!');
    }
}
