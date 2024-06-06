<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\EmailVerificationToken;
use App\Models\MailingList;
use App\Mail\VerificationMail; 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        $data = [
            'title' => 'Login',
            'subTitle' => 'Bilik Hukum',  
        ];

        return view('Auth.login', $data);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email-username', 'password');
    
        // Cek apakah input adalah email atau username
        $loginField = filter_var($credentials['email-username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Buat array untuk kredensial berdasarkan input pengguna
        $credentialsToAttempt = [
            $loginField => $credentials['email-username'],
            'password' => $credentials['password']
        ];
    
        // Coba melakukan autentikasi
        if (Auth::attempt($credentialsToAttempt)) {
            // Periksa apakah akun pengguna telah diverifikasi melalui email
            $user = User::where($loginField, $credentials['email-username'])->first();
    
            if ($user && !$user->verified) {
                // Akun belum diverifikasi, kirimkan pesan kesalahan
                $errorMessage = 'Email belum diverifikasi.';
                $response = [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => $errorMessage,
                ];
                return redirect()->back()->with('response', $response);
            }             
            
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Anda berhasil login.',
            ];
            return redirect()->route('account.profile')->with('response', $response);
        }
    
        // Autentikasi gagal, buat pesan kesalahan
        $errorMessage = 'Username/Email dan Password Salah';
    
        // Buat respons untuk SweetAlert
        $response = [
            'success' => false,
            'title' => 'Gagal',
            'message' => $errorMessage,
        ];
    
        // Kembalikan respons ke halaman login
        return redirect()->back()->with('response', $response);
    }
    
    public function showRegister()
    {
        $data = [
            'title' => 'Metode Pendaftaran',
            'subTitle' => 'Bilik Hukum',  
        ];

        return view('Auth.register', $data);
    }
    
    public function showRegisterJoin(Request $request)
    {
        // Ambil token dari query string
        $token = $request->query('token');

        // Jika token ada di query string, simpan ke session
        if ($token) {
            session(['referral_token' => $token]);
        }
    
        $token = session('referral_token');

        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/verify-email?uniqueid=";
        } else {
            // Application is running on the server
            $url = "https://portal.bilikhukum.com/verify-email?uniqueid=";
        }

        $data = [
            'title' => 'Pendaftaran Member',
            'subTitle' => 'Bilik Hukum',
            'url' => $url,
            'token' => $token
        ];

        return view('Auth.join', $data);
    }

    public function registerJoin(Request $request)
    {
        try {
            $token = $request->input('token');
            if (empty($token)) {
                // Jika tidak ada, kembalikan respons dengan pesan tautan pendaftaran tidak valid
                $response = [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Tautan pendaftaran Anda tidak valid.',
                ];
                return redirect()->back()->with('response', $response);
            }

            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'terms' => 'accepted',
            ]);
    
            // Cek apakah persyaratan disetujui
            if ($request->has('terms')) {                
                $username = strtolower($validatedData['username']);
    
                DB::beginTransaction();
    
                $user = User::create([
                    'username' => $username,
                    'referedby' => $token,
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => bcrypt($validatedData['password']),   
                    'role'              => 3,
                    'verified'          => 0,
                    'email_verified_at' => null,
                    'whatsapp'          => 'default_value',
                    'address'           => 'default_value',
                    'gender'            => 'default_value',
                    'image'             => 'default.webp',
                    'dob'               => null, // or '1900-01-01'         
                ]);
    
                $token = Str::random(64);
                $emailVerificationToken = EmailVerificationToken::create([
                    'user_id' => $user->id,
                    'token' => $token,
                    'email' => $request->input('email'),
                    'expires_at' => now()->addHours(24),
                ]);
    
                MailingList::create([
                    'user_id' => $user->id,
                    'email' => $request->input('email'),
                    'status' => 1, // Default status is 1
                ]);
    
                $email = $request->input('email');
                $name = $request->input('name');
                $url = $request->input('url');
                $encryptedParams = base64_encode("email=$email&token=$token");
    
                Mail::to($email)->send(new VerificationMail($name, $url, $encryptedParams));
    
                DB::commit();
    
                $response = [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Akun anda berhasil terdaftar. Check Mailbox untuk verifikasi dan Login.',
                ];
                return redirect()->route('login')->with('response', $response);
            } else {
                // Redirect kembali ke halaman sebelumnya jika persyaratan tidak disetujui
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Silakan centang persyaratan dan ketentuan.',
                    ],
                ]);
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollback();
    
            // Tampilkan pesan kesalahan dengan sweet alert dan redirect kembali
            $response = [
                'success' => false,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat proses registrasi: ' . $e->getMessage(),
            ];
            return redirect()->back()->with('response', $response);
        }
    }


    public function showRegisterMember()
    {
        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/verify-email?uniqueid=";
        } else {
            // Application is running on the server
            $url = "https://portal.bilikhukum.com/verify-email?uniqueid=";
        }
    
        $data = [
            'title' => 'Pendaftaran Member',
            'subTitle' => 'Bilik Hukum',
            'url' => $url
        ];
    
        return view('Auth.registerMember', $data);
    }

//eror    
    public function showRegisterPengacara()
    {
        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/verify-email?uniqueid=";
        } else {
            // Application is running on the server
            $url = "https://portal.bilikhukum.com/verify-email?uniqueid=";
        }
    
        $data = [
            'title' => 'Pendaftaran Pengacara',
            'subTitle' => 'Bilik Hukum',
            'url' => $url
        ];

        return view('Auth.registerPengacara', $data);
    }

    public function registerMember(Request $request)
    {
        try {            
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
                'gender' => 'required',
                'multiStepsVillage' => 'required|string',
                'multiStepsProfileImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'multiStepsProfileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Make image nullable
                'dob' => 'required|date',
            ]);
    
            // Transaksi database
            \DB::beginTransaction();
    
            // Pengolahan gambar
            $image = $request->file('multiStepsProfileImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $newName = time();
    
            // Simpan gambar sementara
            $image->move('temp', $imageName);

            try {
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read('temp/'. $imageName);                            
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
                $encodedImage->save(public_path('assets/img/member/'. $newName.'.webp'));        

                // Hapus gambar sementara
                unlink('temp/' . $imageName);
            } catch (\Exception $e) {
                // Hapus gambar sementara jika terjadi kesalahan
                if (file_exists('temp/' . $imageName)) {
                    unlink('temp/' . $imageName);
                }
                throw $e;
            }
            
            // Buat pengguna baru
            $user = User::create([
                'name'              => $request->input('multiStepsName'),
                'username'          => $request->input('multiStepsUsername'),
                'email'             => $request->input('multiStepsEmail'),
                'whatsapp'          => $request->input('multiStepsWhatsapp'),
                'password'          => Hash::make($request->input('multiStepsPass')),
                'address'           => $request->input('multiStepsVillage'),
                'gender'            => $request->input('gender'),
                'image'             => $newName . '.webp',
                'role'              => 3,
                'dob'               => $request->input('dob'),
                'verified'          => 0,
                'email_verified_at' => null,
            ]);
    
            $token = Str::random(64);
            $emailVerificationToken = EmailVerificationToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'email' => $request->input('multiStepsEmail'),
                'expires_at' => now()->addHours(24),
            ]);
    
            // Membuat entri di dalam tabel MailingList
            MailingList::create([
                'user_id' => $user->id,
                'email' => $request->input('multiStepsEmail'),
                'status' => 1, // Default status is 1
            ]);
    
            // Kirim email verifikasi
            $email = $request->input('multiStepsEmail');
            $name = $request->input('multiStepsName');
            $url = $request->input('url');
            $encryptedParams = base64_encode("email=$email&token=$token");
    
            Mail::to($email)->send(new VerificationMail($name, $url, $encryptedParams));
    
            \DB::commit();
    
            // Menyusun respon sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Akun anda berhasil terdaftar. Check Mailbox untuk verifikasi dan Login.',
            ];
    
            return redirect()->route('login')->with('response', $response);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
    
            // Menangani error validasi
            $errors = $e->errors();
            $errorMessage = 'Terdapat kesalahan dalam input data Anda: ';
    
            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages) . ' ';
            }
    
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $errorMessage,
            ];
    
            return redirect()->back()->with('response', $response)->withErrors($errors);
    
        } catch (\Exception $e) {
            \DB::rollBack();
    
            // Menangani error lainnya
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
            ];
    
            return redirect()->back()->with('response', $response);
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
//eror
    public function verifyEmail(Request $request)
    {
        try {
            $uniqueId = $request->query('uniqueid');
            $decodedParams = base64_decode($uniqueId);
    
            // Mendekode string menjadi array asosiatif
            parse_str($decodedParams, $params);
    
            // Mendapatkan email dan token dari array
            $email = $params['email'];
            $token = $params['token'];
    
            // Menggunakan transaksi untuk mengelola pengecualian secara keseluruhan
            DB::beginTransaction();
    
            // Mengambil token verifikasi
            $verificationToken = EmailVerificationToken::where('email', $email)
                ->where('token', $token)
                ->first();
    
            // Jika token tidak ditemukan atau sudah kadaluarsa
            if (!$verificationToken || $verificationToken->expires_at < now()) {
                throw new \Exception('Token verifikasi email tidak valid atau sudah kadaluarsa.');
            }
    
            // Ubah status verifikasi email pada user
            $user = User::where('email', $email)->first();
            if (!$user) {
                throw new \Exception('User tidak ditemukan.');
            }
            $user->verified = 1;
            $user->email_verified_at = now(); // Isi dengan waktu verifikasi email
            $user->save();
    
            // Hapus token verifikasi dari database
            EmailVerificationToken::where('email', $email)->delete();
    
            // Commit transaksi jika tidak ada pengecualian
            DB::commit();
    
            // Set response untuk pesan sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Akun anda berhasil Terverifikasi. Silahkan Login',
            ];
    
            // Redirect pengguna ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('response', $response);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi pengecualian
            DB::rollBack();
    
            // Set response untuk pesan kesalahan
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => $e->getMessage(),
            ];
    
            // Redirect pengguna ke halaman login dengan pesan kesalahan
            return redirect()->route('login')->with('response', $response);
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
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
