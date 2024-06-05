<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Referral;

class ReferralController extends Controller
{

    public function showReferral(Request $request)
    {        
        $accessMenus    = $request->get('accessMenus');        
        $data = [
            'title'             => 'Refferal',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $accessMenus,          
        ];

        return view('Portal.Account.refferal', $data);
    }

    public function processReferral(Request $request)
    {
        // Validate the referral form data
        $request->validate([
            'referrer_email' => 'required|email|exists:users,email',
            'referral_email' => 'required|email|unique:referrals,email',
        ]);

        // Find the referrer user
        $referrer = User::where('email', $request->referrer_email)->first();

        // Create a new referral record
        $referral = new Referral([
            'referrer_id' => $referrer->id,
            'email' => $request->referral_email,
        ]);
        $referral->save();
    
        return redirect()->back()->with('success', 'Referral has been submitted successfully.');
    }
}