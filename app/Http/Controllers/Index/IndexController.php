<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

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

        $currentDate = Carbon::now();
       
        $posts = Post::where('post_status', 'publish')
        ->orWhere(function($query) use ($currentDate) {
            $query->where('post_status', 'future')
                  ->where('post_date', '<=', $currentDate);
        })
        ->orderBy('post_date', 'desc')
        ->take(4)
        ->get();

        // dd($posts);

        $data = [
            'meta_description' => 'Temukan solusi hukum terbaik di bilikhukum.com. Kami menyediakan layanan pengacara, notaris, dan konsultasi hukum profesional. Dapatkan bantuan hukum yang Anda butuhkan dengan mudah dan cepat.',
            'meta_keywords' => 'hukum, pengacara, notaris, konsultasi hukum, jasa hukum, bantuan hukum',
            'meta_author' => 'Bilik Hukum',
            'token' => '3wnY0chj',
            'url' => $url,
            'title' => 'Bilik Hukum - Solusi Hukum Terbaik',
            'posts' => $posts,
        ];

        return view('Index.index', $data);
    }
}
