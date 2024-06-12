<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class KlienChatNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $klienChat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($klienChat)
    {
        $this->klienChat = $klienChat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $lawyerUrl = config('app.url') === 'http://localhost' ? 'http://127.0.0.1:8000/lawyer/klien' : 'https://bilikhukum.com/lawyer/klien';     
        return $this->view('Mail.klien_chat_notification')
                    ->with([                     
                        'url' => $lawyerUrl,
                        'keperluan' => $this->klienChat->keperluan,
                    ])
                    ->subject('Notifikasi Klien Baru');
    }
}
