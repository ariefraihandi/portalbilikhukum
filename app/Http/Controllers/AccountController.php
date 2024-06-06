<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RefferalCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function showAccount(Request $request)
    {        
        $accessMenus    = $request->get('accessMenus');        
        $id             = $request->session()->get('user_id');
        $user           = User::find($id);           
        $referralCode   = RefferalCode::where('user_id', $id)->first();  
       
        //Count Eror
            $countDefaultValues = 0;
            $countNullValues = 0;
            
            foreach ($user->getAttributes() as $attribute => $value) {
                if ($value === 'default_value') {
                    $countDefaultValues++;
                } elseif ($value === null) {
                    $countNullValues++;
                }
            }
        //!Count Eror      
       
        $erorDetil = $countDefaultValues+$countNullValues-1;

        $data = [
            'title'             => 'Profile',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $accessMenus,
            'userDetils'        => $user,
            'hasReferralCode'   => $referralCode,
            'erorDetil'         => $erorDetil
            
        ];


        return view('Portal.Account.profile', $data);
    }
   
    public function showAccountDetil(Request $request)
    {        
        $accessMenus    = $request->get('accessMenus');        
        $id             = $request->session()->get('id');
        $user           = User::find($id);           
        $referralCode   = RefferalCode::where('user_id', $id)->first();  
       
        //Count Eror
            $countDefaultValues = 0;
            $countNullValues = 0;
            
            foreach ($user->getAttributes() as $attribute => $value) {
                if ($value === 'default_value') {
                    $countDefaultValues++;
                } elseif ($value === null) {
                    $countNullValues++;
                }
            }
        //!Count Eror      
       
        $erorDetil = $countDefaultValues+$countNullValues+3;

        $data = [
            'title'             => 'Profile',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $accessMenus,
            'userDetils'        => $user,
            'hasReferralCode'   => $referralCode,
            'erorDetil'         => $erorDetil
            
        ];


        return view('Portal.Account.accountDetil', $data);
    }
}