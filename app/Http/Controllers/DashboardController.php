<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'subtitle' => 'Bilik Hukum',  
        ];

        return view('Portal.dasboard', $data);
    }
}
