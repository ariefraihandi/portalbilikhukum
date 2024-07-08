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
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Office;
use App\Models\OfficeMember;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\OfficeActivity;
use App\Models\EmailVerificationToken;
use App\Models\MailingList;
use App\Mail\VerificationMail; 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use App\Notifications\VerifyEmailNotification;

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
    
    public function showVerifyMail()
    {
        $data = [
            'title' => 'Verifikasi Email',
            'subTitle' => 'Bilik Hukum',  
        ];

        return view('Auth.verifyMail', $data);
    }

    public function sendEmailVerify(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Check if the email exists in the users table
        $user = User::where('email', $request->input('email'))->first();
    
        if ($user) {
            // Check if a verification token already exists for this user
            $token = EmailVerificationToken::where('email', $request->input('email'))->first();
    
            if ($token) {
                // Update the expires_at field
                $token->update([
                    'expires_at' => Carbon::now()->addMinutes(60),
                ]);
            } else {
                // Create a new token
                $token = EmailVerificationToken::create([
                    'user_id' => $user->id,
                    'token' => bin2hex(random_bytes(16)),
                    'email' => $request->input('email'),
                    'expires_at' => Carbon::now()->addMinutes(60),
                ]);
            }
    
            // Prepare the URL and parameters
            $url = config('app.url') === 'http://localhost' ? 
                   "http://127.0.0.1:8000/verify-email?uniqueid=" : 
                   "https://bilikhukum.com/verify-email?uniqueid=";
            $encryptedParams = base64_encode("email={$request->input('email')}&token={$token->token}");
    
            // Send the email
            $user->notify(new VerifyEmailNotification($user->name, $url, $encryptedParams));
    
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Email Verifikasi Berhasil Dikirimkan.',
            ];
            return redirect()->route('login')->with('response', $response);
        } else {
            $response = [
                'success' => false,
                'title' => 'Eror',
                'message' => 'Email tidak ditemukan',
            ];
            return redirect()->back()->with('response', $response);
        }
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
            
            // Ambil URL tujuan dari sesi atau default ke halaman profil
            $intendedUrl = Session::get('url.intended', route('account.profile'));
            
            // Bersihkan URL tujuan dari sesi
            Session::forget('url.intended');
    
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Anda berhasil login.',
            ];
            
            // Redirect ke URL yang disimpan di sesi atau ke halaman profil
            return redirect()->intended($intendedUrl)->with('response', $response);
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
        $office_id = session('office_id');
        $type = session('type');

        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/verify-email?uniqueid=";
        } else {
            // Application is running on the server
            $url = "https://bilikhukum.com/verify-email?uniqueid=";
        }

        $data = [
            'meta_description' => 'Daftarkan kantor hukum Anda dan bergabunglah bersama bilikhukum.com. Kami menyediakan platform untuk pengacara, notaris dan mediator profesional yang siap membantu berbagai masalah hukum, mulai dari perkara pidana, perdata, hingga bisnis. Konsultasi gratis tersedia.',
            'meta_keywords' => 'pengacara, jasa pengacara, konsultasi pengacara, bantuan hukum, pengacara pidana, pengacara perdata, pengacara bisnis',
            'meta_author' => 'Bilik Hukum',
            'title' => 'Pendaftaran Member',
            'subTitle' => 'Bilik Hukum',
            'url' => $url,
            'token' => $token,
            'office_id' => $office_id,
            'type' => $type
        ];

        return view('Auth.join', $data);
    }

    public function registerJoin(Request $request)
{
    try {
        $token = $request->input('token');
        $officeId = $request->input('office_id');
        $type = $request->input('type');

        if (empty($token)) {
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
            'whatsapp' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        if ($request->has('terms')) {
            $username = strtolower($validatedData['username']);

            DB::beginTransaction();
            $validatedData['whatsapp'] = $this->formatWhatsAppNumber($validatedData['whatsapp']);
            $user = User::create([
                'username' => $username,
                'referedby' => $token,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => $officeId ? 4 : 3,
                'verified' => 0,
                'email_verified_at' => null,
                'whatsapp' => $validatedData['whatsapp'],
                'address' => 'default_value',
                'gender' => 'default_value',
                'image' => 'default.webp',
                'dob' => null,
            ]);

            if ($officeId) {
                OfficeMember::create([
                    'id_user' => $user->id,
                    'id_office' => $officeId,
                    'level' => $type,
                ]);
            }

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
                'status' => 1,
            ]);

            $email = $request->input('email');
            $name = $request->input('name');
            $url = $request->input('url');
            $encryptedParams = base64_encode("email=$email&token=$token");

            $user->notify(new VerifyEmailNotification($name, $url, $encryptedParams));

            DB::commit();

            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Akun Anda berhasil terdaftar. Periksa email untuk verifikasi dan Login.',
            ];
            return redirect()->route('login')->with('response', $response);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Silakan centang persyaratan dan ketentuan.',
                ],
            ]);
        }
    } catch (\Exception $e) {
        DB::rollback();

        $response = [
            'success' => false,
            'title' => 'Error',
            'message' => 'Terjadi kesalahan saat proses registrasi: ' . $e->getMessage(),
        ];
        return redirect()->back()->with('response', $response);
    }
}

    public function submitFormDaftar(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'officeName' => 'required|string|max:255',
                'officeEmail' => 'required|email|max:255|unique:offices,email_kantor',
                'officePhone' => 'required|string|max:15',
                'flatpickr-date' => 'required|date',
                'officeAddress' => 'required|string|max:255',
                'postCode' => 'required|string|max:10',
                'officeProvince' => 'required|string',
                'officeRegency' => 'required|string',
                'officeDistrict' => 'required|string',
                'officeVillage' => 'required|string',
                'slogan' => 'required|string|max:255',
                'setuju' => 'required|accepted',
            ]);

            $user = auth()->user();

            $office = Office::create([
                'user_id' => auth()->id(),
                'nama_kantor' => $request->officeName,
                'email_kantor' => $request->officeEmail,
                'hp_whatsapp' => $request->officePhone,
                'tanggal_pendirian' => $request->input('flatpickr-date'),
                'alamat' => $request->officeAddress,
                'kode_pos' => $request->postCode,
                'provinsi' => $request->officeProvince,
                'kabupaten_kota' => $request->officeRegency,
                'kecamatan' => $request->officeDistrict,
                'desa' => $request->officeVillage,                
                'slogan' => $request->slogan,
                'agreement' => $request->setuju,
                'referedby' => auth()->user()->referedby,
                'logo' => 'default.webp', 
                'cover' => 'profile-banner.png', 
                'type' => 1, 
                'status' => 0,
            ]);

            $officeMember = OfficeMember::create([
                'id_user' => auth()->id(), 
                'id_office' => $office->id,
                'level' => 'Direktur', 
            ]);

            $activity = OfficeActivity::create([
                'office_id' => $office->id,
                'name' => 'Pendaftaran Kantor Pengacara ' . $request->officeName,
                'description' => 'Kantor Pengacara ' . $request->officeName . ' berhasil didaftarkan.',
                'badge' => 'primary',
                'status' => 0,
            ]);

            $user->role = 4;
            $user->save();

            DB::commit();

            return redirect()->route('lawyer')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Pendaftaran Kantor Berhasil, Segera Lengkapi Profil Kantor Anda',
                ],
            ]);
        } catch (Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            // Mengembalikan pesan kesalahan
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Pendaftaran Kantor Gagal. Mohon coba lagi nanti.',
                ],
            ])->withErrors($e->getMessage());
        }
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

    public function changePassword(Request $request)
    {
        $messages = [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru harus minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ];
    
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => implode(', ', $errors) // Menggabungkan semua pesan kesalahan
            ];
            return redirect()->back()->with('response', $response)->withErrors($e->validator);
        }
    
        // Cek apakah kata sandi saat ini cocok
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Password lama tidak cocok'
            ];
            return redirect()->back()->with('response', $response);
        }
    
        // Ubah kata sandi
        Auth::user()->update(['password' => Hash::make($request->new_password)]);
    
        // Hapus sesi dan redirect ke login
        Auth::logout();
    
        $response = [
            'success' => true,
            'title' => 'Berhasil',
            'message' => 'Password berhasil diubah. Silakan login kembali.',
        ];
    
        return redirect()->route('login')->with('response', $response);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function formatWhatsappNumber($number)
    {      
        $number = preg_replace('/\s|\(|\)|-/', '', $number);

        // Jika nomor diawali dengan 0, ubah menjadi 62
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        // Jika nomor diawali dengan 8, tambahkan 62 di depan
        if (substr($number, 0, 1) == '8') {
            $number = '62' . $number;
        }

        // Jika nomor sudah diawali dengan 62, biarkan
        if (substr($number, 0, 2) == '62') {
            return $number;
        }

        // Jika nomor diawali dengan selain 0, 8, atau 62, mungkin nomor tidak valid
        // Kembalikan nomor apa adanya
        return $number;
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
