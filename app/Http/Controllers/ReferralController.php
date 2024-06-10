<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\RefferalCode;
use App\Models\Role;
use App\Models\User;
use DataTables;
use Carbon\Carbon;


class ReferralController extends Controller
{

    public function showReferral(Request $request)
    {        
        $accessMenus = $request->get('accessMenus');        

        $id             = auth()->id();        
        $referralCode   = RefferalCode::where('user_id', $id)->first();  
        $user           = User::find($id);    

        // Menghitung Eror
            $countDefaultValues = 0;
            $countNullValues = 0;

            foreach ($user->getAttributes() as $attribute => $value) {
                if ($value === 'default_value') {
                    $countDefaultValues++;
                } elseif ($value === null) {
                    $countNullValues++;
                }
            }

            $erorDetil = $countDefaultValues + $countNullValues + 3;

            if ($erorDetil > 4) {
                return redirect()->route('account.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Profile Tidak Lengkap',
                        'message' => 'Harap Lengkapi Detil Profile dahulu sebelum mengakses halaman refferal',
                    ],
                ]);
            }
        //! Menghitung Eror



        $data = [
            'title'             => 'Referral',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $accessMenus,
            'hasReferralCode'   => $referralCode
        ];

        return view('Portal.Account.refferal', $data);
    }

    public function refferalGenerate(Request $request)
    {
        try {

            $randomCode = Str::random(8);
            $userId = auth()->id();
    
            // Simpan data referral code ke database
            $referralCode = new RefferalCode();
            $referralCode->user_id = $userId;
            $referralCode->code = $randomCode;
            $referralCode->agreed = $request->agreed;
            $referralCode->valid = 1;
            $referralCode->save();
    
            // Setelah melakukan proses yang diperlukan, Anda bisa melakukan redirect atau memberikan respon JSON atau lainnya sesuai kebutuhan aplikasi Anda
            return redirect()->back()->with('response', [
                'success' => true,
                'title' => 'Success',
                'message' => 'tautan undangan anda berhasil dibuat',
            ]);
        } catch (\Exception $e) {
            // Tangkap kesalahan dan log pesan kesalahan
            Log::error('Error while generating referral link: ' . $e->getMessage());
            
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->with('response', [
                'success' => false,
                'title' => 'Error',
                'message' => 'Maaf, terjadi kesalahan saat membuat tautan undangan. Silakan coba lagi nanti.',
            ]);
        }
    }

    
    
}