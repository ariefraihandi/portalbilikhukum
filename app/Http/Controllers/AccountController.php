<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\RefferalCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class AccountController extends Controller
{
    //View
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
        
            $erorDetil = $countDefaultValues+$countNullValues+3;

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
    //!View

    //Editing
    public function uploadAvatar(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.detil')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal Merubah Avatar',
                    'message' => 'Avatar tidak sesuai',
                ],
            ]);
        }

        if ($request->hasFile('avatar')) {
            $user = Auth::user();
            $oldImage = $user->image; // Ambil nama gambar lama dari kolom image

            if ($oldImage !== 'default.webp') {
                // Hapus gambar lama jika bukan default.webp
                if (file_exists(public_path('assets/img/member/' . $oldImage))) {
                    unlink(public_path('assets/img/member/' . $oldImage));
                }
            }

            $file = $request->file('avatar');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $newName = Str::random(12) . '.webp';

            $file->move('temp', $imageName);

            $imgManager = new ImageManager(new Driver());
            $profile = $imgManager->read('temp/' . $imageName);
            $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
            $encodedImage->save(public_path('assets/img/member/'. $newName));     

            // Hapus gambar sementara
            unlink('temp/' . $imageName);

            // Update kolom image di database
            $user->update(['image' => $newName]);

            return redirect()->route('account.detil')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Avatar diubah',
                ],
            ]);
        }

        return redirect()->route('account.detil')->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal Merubah Avatar',
                'message' => 'Gagal mengunggah avatar',
            ],
        ]);
    }
    //Editing
}