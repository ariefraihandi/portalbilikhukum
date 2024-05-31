<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika otentikasi berhasil
            return redirect()->intended('/');
        }

        // Jika otentikasi gagal
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function showRegisterMember()
    {
        return view('Auth.register');
    }
    
    public function showRegisterPengacara()
    {
        return view('Auth.registerPengacara');
    }

    public function registerMember(Request $request)
    {
        try {
            // Validasi data input
            $validatedData = $request->validate([
                'multiStepsName' => 'required|string|max:255',
                'multiStepsUsername' => 'required|string|max:255|unique:users,username',
                'multiStepsEmail' => 'required|email|max:255|unique:users,email',
                'multiStepsEmailVerify' => 'required|same:multiStepsEmail',
                'multiStepsWhatsapp' => 'required|string|max:15',
                'multiStepsPass' => 'required|string|min:8',
                'multiStepsConfirmPass' => 'required|string|same:multiStepsPass',
                'multiStepsProvince' => 'required|string',
                'multiStepsRegency' => 'required|string',
                'multiStepsDistrict' => 'required|string',
                'multiStepsVillage' => 'required|string',
                'multiStepsProfileImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg',                
                'flatpickr-date' => 'required|date',                
            ]);

            // Menghandle file upload dan konversi gamba
            
            $image = $request->file('multiStepsProfileImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('temp', $imageName);
            $imgManager = new ImageManager(new Driver());
            $profile = $imgManager->read('temp/'. $imageName);
            $profilea = $profile->width();            
            $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
            $encodedImage->save(public_path('assets/img/member/'. $profilea.'.webp'));        
            

            // Menyimpan data ke dalam database
            // $user = new User();
            // $user->name = $request->input('multiStepsName');
            // $user->username = $request->input('multiStepsUsername');
            // $user->email = $request->input('multiStepsEmail');
            // $user->whatsapp = $request->input('multiStepsWhatsapp');
            // $user->password = Hash::make($request->input('multiStepsPass'));
            // $user->province = $request->input('multiStepsProvince');
            // $user->regency = $request->input('multiStepsRegency');
            // $user->district = $request->input('multiStepsDistrict');
            // $user->village = $request->input('multiStepsVillage');
            // $user->profile_image = $imageName;
            // $user->birthdate = $request->input('flatpickr-date');
            // $user->save();

            // Menyusun respon sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Customer berhasil ditambahkan.'."$imageName"
            ];

            return redirect()->back()->with('response', $response);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Menangani error validasi
            $errors = $e->errors();
            $errorMessage = 'Terdapat kesalahan dalam input data Anda: ';
    
            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages) . ' ';
            }
    
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $errorMessage
            ];
    
            return redirect()->back()->with('response', $response)->withErrors($errors);
        }
    }

    public function submitFormDaftar(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'multiStepsName' => 'required|string',
                'multiStepsUsername' => 'required|string',
                'multiStepsEmail' => 'required|email',
                'multiStepsWhatsapp' => 'required|string',
                'multiStepsPass' => 'required|string|min:8',
                'multiStepsConfirmPass' => 'required|string|same:multiStepsPass',
                'multiStepsProvince' => 'required|string',
                'multiStepsRegency' => 'required|string',
                'multiStepsDistrict' => 'required|string',
                'multiStepsVillage' => 'required|string',
                'multiStepsProfileImage' => 'required|image',
                'officeName' => 'required|string',
                'officeEmail' => 'required|email',
                'officePhone' => 'required|string',
                'flatpickr-date' => 'required|date',
                'officeAddress' => 'required|string',
                'postCode' => 'required|string',
                'officeProvince' => 'required|string',
                'officeRegency' => 'required|string',
                'officeDistrict' => 'required|string',
                'officeVillage' => 'required|string',
                'website' => 'nullable|url',
                'slogan' => 'required|string',
                'logo' => 'required|image',
                'legalDocument' => 'required|file|mimes:pdf,jpeg,png,jpg',
                'setuju' => 'required|accepted',
            ]);
    
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Customer berhasil ditambahkan.'
            ];
    
            return redirect()->back()->with('response', $response);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessage = 'Terdapat kesalahan dalam input data Anda: ';
    
            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages) . ' ';
            }
    
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $errorMessage
            ];
    
            return redirect()->back()->with('response', $response)->withErrors($errors);
        }
    }

    private function processImage($image)
    {
        // Membuat instance gambar menggunakan Intervention Image
        $img = Image::make($image);
    
        // Mengonversi gambar ke format WebP
        $img->encode('webp', 75); // kualitas 75 untuk kompresi WebP
    
        // Memastikan ukuran gambar kurang dari 200 KB
        while (strlen($img->encoded) > 200 * 1024) {
            $img->resize($img->width() * 0.9, $img->height() * 0.9); // mengurangi ukuran gambar
            $img->encode('webp', 75); // re-encode dengan kualitas 75
        }
    
        // Menyimpan gambar sementara di storage
        $imageName = time() . '.webp';
        $img->save(public_path('profile_images/' . $imageName));
    
        return $imageName;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    //Get Data
        public function getProvinces(Request $request)
        {
            if ($request->ajax()) {
                $search = $request->input('search'); // Mengambil nilai pencarian dari request
        
                // Mengambil data provinsi dengan filter berdasarkan nama jika ada parameter pencarian
                $provinces = Province::when($search, function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                })->get();
        
                return response()->json($provinces);
            } else {
                abort(403, 'Unauthorized access');
            }
        }
        public function getProvincesOffice(Request $request)
        {
            if ($request->ajax()) {
                $search = $request->input('search'); // Mengambil nilai pencarian dari request
        
                // Mengambil data provinsi dengan filter berdasarkan nama jika ada parameter pencarian
                $provinces = Province::when($search, function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                })->get();
        
                return response()->json($provinces);
            } else {
                abort(403, 'Unauthorized access');
            }
        }

        public function getRegencies(Request $request)
        {
            if ($request->ajax()) {
                $provinceCode = $request->input('province_code');
                $search = $request->input('search');
        
                $regencies = Regency::where('province_code', $provinceCode)
                                    ->when($search, function ($query) use ($search) {
                                        return $query->where('name', 'like', '%'.$search.'%');
                                    })
                                    ->get();
        
                return response()->json($regencies);
            } else {
                abort(403, 'Unauthorized access');
            }
        }
        
        public function getDistricts(Request $request)
        {
            if ($request->ajax()) {
                $regencyCode = $request->input('regency_code');
                $search = $request->input('search');
        
                $districts = District::where('regency_code', $regencyCode)
                                    ->when($search, function ($query) use ($search) {
                                        return $query->where('name', 'like', '%'.$search.'%');
                                    })
                                    ->get();
        
                return response()->json($districts);
            } else {
                abort(403, 'Unauthorized access');
            }
        }
        
        public function getVillages(Request $request)
        {
            if ($request->ajax()) {
                $districtCode = $request->input('district_code');
                $search = $request->input('search');
        
                $villages = Village::where('district_code', $districtCode)
                                    ->when($search, function ($query) use ($search) {
                                        return $query->where('name', 'like', '%'.$search.'%');
                                    })
                                    ->get();
        
                return response()->json($villages);
            } else {
                abort(403, 'Unauthorized access');
            }
        }
        
    //!Get Data
}
