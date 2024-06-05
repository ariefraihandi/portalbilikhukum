<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard(Request $request)
    {
        $accessMenus    = $request->get('accessMenus');

        $data = [
            'title' => 'Dashboard',
            'subtitle' => 'Bilik Hukum',  
            'sidebar'           => $accessMenus,
        ];

        return view('Portal.dasboard', $data);
    }
}
