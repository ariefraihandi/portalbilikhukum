<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // Display a listing of the users
    public function showAccount(Request $request)
    {        
        $accessMenus    = $request->get('accessMenus');        
        $id             = $request->session()->get('id');
        $user           = User::find($id);

        $data = [
            'title'             => 'Profile',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $accessMenus,
            'userDetils'        => $user,
            
        ];


        return view('Portal.Account.profile', $data);
    }
}