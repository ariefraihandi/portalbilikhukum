<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        
        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/verify-email?uniqueid=";
        } else {
            // Application is running on the server
            $url = "https://bilikhukum.com/verify-email?uniqueid=";
        }

        $data = [
            'meta_description' => 'Temukan solusi hukum terbaik di bilikhukum.com. Kami menyediakan layanan pengacara, notaris, dan konsultasi hukum profesional. Dapatkan bantuan hukum yang Anda butuhkan dengan mudah dan cepat.',
            'meta_keywords' => 'hukum, pengacara, notaris, konsultasi hukum, jasa hukum, bantuan hukum',
            'meta_author' => 'Bilik Hukum',
            'token' => '3wnY0chj',
            'url' => $url,
            'title' => 'Bilik Hukum - Solusi Hukum Terbaik',
        ];

        return view('index.index', $data);
    }
}
