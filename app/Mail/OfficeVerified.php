<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfficeVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $office;

    public function __construct($office)
    {
        $this->office = $office;
    }

    public function build()
    {
        $url = config('app.url') === 'http://localhost' ? 'http://127.0.0.1:8000/lawyer' : 'https://bilikhukum.com/lawyer';
        $lawyerUrl = $url . 'lawyer';

        return $this->view('Mail.office_verified')
                    ->with([
                        'officeName' => $this->office->nama_kantor,
                        'lawyerUrl' => $lawyerUrl,
                    ]);
    }
}
