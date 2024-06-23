<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\OfficeMember;
use App\Models\OfficeActivity;
use App\Models\KlienChat;
use App\Models\OfficeDocument;
use App\Models\LegalCase;
use App\Models\OfficeCase;
use App\Models\OfficeGallery;
use App\Models\Office;
use App\Models\OfficeSite;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\OfficeVerificationList;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use App\Notifications\OfficeVerificationRequestNotification;
use DataTables;


class LawyerController extends Controller
{
    public function showJoinOffice(Request $request)
    {
        // Ambil nilai token, office_id, dan type dari query string
        $token = $request->query('token');
        $officeId = $request->query('office_id');
        $type = $request->query('type');
    
        // Pastikan nilai token, office_id, dan type tidak kosong
        if ($token && $officeId && $type) {
            // Simpan nilai token, office_id, dan type ke dalam session
            $request->session()->put('referral_token', $token);
            $request->session()->put('office_id', $officeId);
            $request->session()->put('type', $type);
    
            // Kirim data ke view
            $data = [
                'officeId' => $officeId,
                'type' => $type,
            ];
    
            return view('Auth.joinOffice', $data);
        } else {
            // Handle jika token, office_id, atau type tidak ada
            return abort(404);
        }
    }
    
    public function submitJoinOffice(Request $request)
    {
        try {
            // Ambil id pengguna yang sedang login
            $userId = Auth::id();
            
            // Cek apakah pengguna sudah terdaftar di office_members
            $existingMember = OfficeMember::where('id_user', $userId)->exists();
            if ($existingMember) {
                return redirect()->route('account.profile')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Undangan gagal',
                        'message' => 'Anda sudah bergabung dengan kantor lain.',
                    ]
                ]);
            }

            // Ambil data pengguna dari database
            $user = User::findOrFail($userId);

            // Ambil data dari form
            $officeId = $request->input('office_id');
            $type = $request->input('type');

            // Validasi bahwa office_id dan type tidak kosong
            if (!$officeId || !$type) {
                return redirect()->route('account.profile')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Data office_id dan type tidak valid.',
                    ]
                ]);
            }

            // Validasi apakah office_id ada di database offices
            $office = Office::find($officeId);
            if (!$office) {
                return redirect()->route('account.profile')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'ID kantor tidak valid atau tidak ditemukan.',
                    ]
                ]);
            }

            // Ubah role pengguna menjadi 4
            $user->role = 4;
            $user->save();

            // Tambahkan pengguna ke dalam office_members
            $officeMember = OfficeMember::create([
                'id_user' => $userId,
                'id_office' => $officeId,
                'level' => $type,
            ]);

            return redirect()->route('lawyer')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Anda telah berhasil bergabung dengan kantor.',
                ]
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal bergabung dengan kantor: ' . $e->getMessage());
        }
    }

    public function showLawyer(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId = $officeMember->id_office;
            
            $office                     = Office::find($officeId);
            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $officeActivities           = OfficeActivity::where('office_id', $office->id)
                                        ->orderBy('created_at', 'desc')
                                        ->limit(10)
                                        ->get();
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get();
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();

            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });

            $labelCount = $this->determineLabel($averageFee);

            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeActivities'  => $officeActivities,
                'officeDocuments'   => $officeDocuments,
                'labelCount'        => $labelCount,
                'klienChatStatus0Count' => $klienChatStatus0Count,
            ];

            return view('Portal.Pengacara.index', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);      
        }
    }
    
    public function showLawyerDetil(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId                   = $officeMember->id_office;
            $office                     = Office::where('type', 1)->find($officeId);            
            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');            
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get(); // Fetch office cases
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();

            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });

            $labelCount = $this->determineLabel($averageFee);

            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeDocuments'   => $officeDocuments,
                'labelCount'        => $labelCount,
                'klienChatStatus0Count' => $klienChatStatus0Count,
            ];

            return view('Portal.Pengacara.detilKantor', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);    
        }
    }
    
    public function showLawyerPerkara(Request $request)
    {
        Carbon::setLocale('id');

        $userId = Auth::id();
        $officeMember = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId = $officeMember->id_office;
            $office = Office::where('type', 1)->find($officeId);

            // Check office status
            if ($office->status <= 1) {
                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Kantor anda belum Terverifikasi',
                    ],
                ]);
            }

            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $legalCategories            = LegalCase::all();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get();
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();

            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });

            $labelCount = $this->determineLabel($averageFee);

            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeDocuments'   => $officeDocuments,
                'legalCategories'   => $legalCategories,
                'officeCases'       => $officeCases, // Pass office cases to the view
                'labelCount'        => $labelCount,
                'klienChatStatus0Count' => $klienChatStatus0Count,
            ];

            return view('Portal.Pengacara.perkaraBiaya', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);
        }
    }

    public function showKlienLawyer(Request $request)
    {
        Carbon::setLocale('id');
    
        $userId = Auth::id();
        $officeMember = OfficeMember::where('id_user', $userId)->first();
    
        if ($officeMember) {
            $officeId = $officeMember->id_office;
            
            $office                     = Office::find($officeId);
            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $officeActivities           = OfficeActivity::where('office_id', $office->id)->orderBy('created_at', 'desc')->limit(10)->get();
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get(); // Fetch office cases
            $klienChats                 = KlienChat::where('id_office', $officeId)->latest()->take(3)->get();
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();
            $klienChatsForStatus        = KlienChat::where('id_office', $officeId)->get();

    
            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });
    
            $labelCount = $this->determineLabel($averageFee);
    
            $data = [
                'title' => 'Pengacara',
                'subtitle' => 'Bilik Hukum',
                'sidebar' => $request->get('accessMenus'),
                'office' => $office,
                'joinedDate' => $joinedDate,
                'officeActivities' => $officeActivities,
                'officeDocuments' => $officeDocuments,                
                'labelCount' => $labelCount,
                'klienChats' => $klienChats,
                'klienChatStatus0Count' => $klienChatStatus0Count,
                'klienChatsForStatus' => $klienChatsForStatus,
            ];
    
            return view('Portal.Pengacara.klien', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);      
        }
    }
    
    public function showWebsiteLawyer(Request $request)
    {
        Carbon::setLocale('id');

        $userId = Auth::id();
        $officeMember = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId           = $officeMember->id_office;
            $office             = Office::where('type', 1)->find($officeId);
            $officeSite         = OfficeSite::where('office_id', $officeId)->first();

            // Check office status
            if ($office->status <= 1) {
                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Kantor anda belum Terverifikasi',
                    ],
                ]);
            }

            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $legalCategories            = LegalCase::all();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get();
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();            
            $officeGalleries = OfficeGallery::where('office_id', $officeId)
                                            ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at descending
                                            ->take(10) // Ambil sepuluh data terbaru
                                            ->get(); 

            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });

            $labelCount = $this->determineLabel($averageFee);

            $data = [
                'title'                     => 'Pengacara',
                'subtitle'                  => 'Bilik Hukum',
                'sidebar'                   => $request->get('accessMenus'),
                'office'                    => $office,
                'joinedDate'                => $joinedDate,
                'officeDocuments'           => $officeDocuments,
                'legalCategories'           => $legalCategories,
                'officeCases'               => $officeCases, // Pass office cases to the view
                'labelCount'                => $labelCount,
                'officeSite'                => $officeSite,
                'klienChatStatus0Count'     => $klienChatStatus0Count,
                'officeGalleries'           => $officeGalleries,
            ];

            return view('Portal.Pengacara.website', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);
        }
    }

    public function showMemberDetil(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $user           = User::where('id', $userId)->first();
        $referedby      = $user->referedby;

        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId                   = $officeMember->id_office;
            $office                     = Office::where('type', 1)->find($officeId);            
            $joinedDate                 = Carbon::parse($office->created_at)->translatedFormat('F Y');            
            $officeDocuments            = OfficeDocument::where('office_id', $officeId)->get();
            $officeCases                = OfficeCase::where('office_id', $officeId)->with('legalCase')->get(); // Fetch office cases
            $klienChatStatus0Count      = KlienChat::where('id_office', $officeId)->where('status', 0)->count();

            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });

            $labelCount = $this->determineLabel($averageFee);

            $data = [
                'title'                 => 'Pengacara',
                'subtitle'              => 'Bilik Hukum',
                'sidebar'               => $request->get('accessMenus'),
                'office'                => $office,
                'joinedDate'            => $joinedDate,
                'officeDocuments'       => $officeDocuments,
                'labelCount'            => $labelCount,
                'referedby'             => $referedby,
                'klienChatStatus0Count' => $klienChatStatus0Count,
            ];

            return view('Portal.Pengacara.member', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Anda belum terdaftar sebagai anggota kantor.',
                ],
            ]);    
        }
    }
    
//Editing
    public function uploadOfficeLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lawyer.detil')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal Merubah Logo',
                    'message' => 'Logo tidak sesuai',
                ],
            ]);
        }

        if ($request->hasFile('logo')) {
            $user = Auth::user();
            $office = Office::where('user_id', $user->id)->first(); // Ambil data kantor dari ID user yang login

            if ($office) {
                $oldImage = $office->logo; // Ambil nama gambar lama dari kolom logo

                if ($oldImage !== 'default.webp') {
                    // Hapus gambar lama jika bukan default.webp
                    if (file_exists(public_path('assets/img/office/logo/' . $oldImage))) {
                        unlink(public_path('assets/img/office/logo/' . $oldImage));
                    }
                }

                $file = $request->file('logo');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';

                $file->move('temp', $imageName);
                
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read('temp/' . $imageName);
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
                $encodedImage->save(public_path('assets/img/office/logo/'. $newName));  

                // Hapus gambar sementara
                unlink('temp/' . $imageName);

                // Update kolom logo di database
                $office->update(['logo' => $newName]);
                
                OfficeActivity::create([
                    'office_id' => $office->id,
                    'name' => 'Logo Updated',
                    'description' => 'The office logo has been updated.',
                    'badge' => 'primary',
                    'status' => '1',
                ]);

                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Logo diubah',
                    ],
                ]);
            } else {
                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal Merubah Logo',
                        'message' => 'Kantor tidak ditemukan',
                    ],
                ]);
            }
        }

        return redirect()->route('lawyer.detil')->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal Merubah Logo',
                'message' => 'Gagal mengunggah logo',
            ],
        ]);
    }
    
    public function uploadOfficeCover(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lawyer.detil')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal Merubah Cover',
                    'message' => 'Cover tidak sesuai',
                ],
            ]);
        }

        if ($request->hasFile('cover')) {      
            $userId = Auth::id();
               
            $officeMember = OfficeMember::where('id_user', $userId)->firstOrFail();


            $office = Office::where('id', $officeMember->id_office)->first(); 

            if ($office) {
                $oldImage = $office->logo; // Ambil nama gambar lama dari kolom logo

                if ($oldImage !== 'profile-banner.png') {
                    if (file_exists(public_path('assets/img/office/cover/' . $oldImage))) {
                        unlink(public_path('assets/img/office/cover/' . $oldImage));
                    }
                }

                $file = $request->file('cover');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';

                $file->move('temp', $imageName);
                
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read('temp/' . $imageName);
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));             
                $encodedImage->save(public_path('assets/img/office/cover/'. $newName));  

                // Hapus gambar sementara
                unlink('temp/' . $imageName);

                // Update kolom logo di database
                $office->update(['cover' => $newName]);

                OfficeActivity::create([
                    'office_id' => $office->id,
                    'name' => 'Cover Updated',
                    'description' => 'The office cover has been updated.',
                    'badge' => 'primary',
                    'status' => '1',
                ]);

                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Berhasil',
                        'message' => 'Cover diubah',
                    ],
                ]);
            } else {
                return redirect()->route('lawyer.detil')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal Merubah Cover',
                        'message' => 'Kantor tidak ditemukan',
                    ],
                ]);
            }
        }

        return redirect()->route('lawyer.detil')->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal Merubah Logo',
                'message' => 'Gagal mengunggah logo',
            ],
        ]);
    }

    public function uploadImageWebsite(Request $request)
    {
        // Validate file
        $validator = Validator::make($request->all(), [
            'fileImage' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('lawyer.website')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Failed to Change Image',
                    'message' => 'Invalid image format',
                ],
            ]);
        }
    
        if ($request->hasFile('fileImage')) {      
            $userId = Auth::id();
            $officeMember = OfficeMember::where('id_user', $userId)->firstOrFail();
            $office = OfficeSite::where('office_id', $officeMember->id_office)->first(); 
    
            if ($office) {
                $type = $request->input('type');
                $columnMap = [
                    'icon_imageFile' => 'icon_image',
                    'logo_imageFile' => 'logo_image',
                    'owner_imageFile' => 'owner_image',
                    'owner_sec_imageFile' => 'owner_sec_image'
                ];
                
                $column = $columnMap[$type];
                $oldImage = $office->$column; // Get the old image name from the respective column
    
                // Ensure default images are not deleted
                if (!in_array($oldImage, ['profile-banner.png', 'logo_default.png', 'default-image.webp', 'icon_default.webp'])) {
                    if (file_exists(public_path('assets/img/office/site/' . $oldImage))) {
                        unlink(public_path('assets/img/office/site/' . $oldImage));
                    }
                }
    
                $file = $request->file('fileImage');
                $imageName = time() . '.' . $file->getClientOriginalExtension();
                $newName = Str::random(12) . '.webp';
    
                $file->move('temp', $imageName);
    
                $imgManager = new ImageManager(new Driver());
                $profile = $imgManager->read('temp/' . $imageName);                  
                $encodedImage = $profile->encode(new WebpEncoder(quality: 65));                 
                $encodedImage->save(public_path('assets/img/office/site/'. $newName));  
    
                // Delete temporary image
                unlink('temp/' . $imageName);
    
                // Update the respective column in the database
                $office->update([$column => $newName]);
    
                OfficeActivity::create([
                    'office_id' => $office->id,
                    'name' => ucfirst(str_replace('_', ' ', $column)) . ' Updated',
                    'description' => 'The office ' . str_replace('_', ' ', $column) . ' has been updated.',
                    'badge' => 'primary',
                    'status' => '1',
                ]);
    
                return redirect()->route('lawyer.website')->with([
                    'response' => [
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Gambar Diupdated',
                    ],
                ]);
            } else {
                return redirect()->route('lawyer.website')->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Failed to Change Cover',
                        'message' => 'Office not found',
                    ],
                ]);
            }
        }
    
        return redirect()->route('lawyer.detil')->with([
            'response' => [
                'success' => false,
                'title' => 'Failed to Change Logo',
                'message' => 'Failed to upload logo',
            ],
        ]);
    }
    

    public function officeUpdate(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'officeName' => 'required|string|max:255',
            'officeEmail' => 'required|email|max:255',
            'officePhone' => 'required|string|max:20',
            'officedesa' => 'required|string|max:255',
            'postCode' => 'required|string|max:10',   
            'multiStepsProvince' => 'required|string|max:255',
            'multiStepsRegency' => 'required|string|max:255',
            'multiStepsDistrict' => 'required|string|max:255',
            'multiStepsVillage' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $office = Office::where('user_id', $user->id)->first();

        if ($office) {
            // Update data kantor
            $office->update([
                'nama_kantor' => $validatedData['officeName'],
                'email_kantor' => $validatedData['officeEmail'],
                'hp_whatsapp' => $validatedData['officePhone'],
                'alamat' => $validatedData['officedesa'],
                'kode_pos' => $validatedData['postCode'],
                'provinsi' => $validatedData['multiStepsProvince'],
                'kabupaten_kota' => $validatedData['multiStepsRegency'],
                'kecamatan' => $validatedData['multiStepsDistrict'],
                'desa' => $validatedData['multiStepsVillage'],
            ]);

            // Tambahkan aktivitas kantor
            OfficeActivity::create([
                'office_id' => $office->id,
                'name' => 'Office Updated',
                'description' => 'Office details were updated.',
                'badge' => 'primary',
                'status' => '1',
            ]);

            return redirect()->route('lawyer.detil')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Data kantor telah diperbarui',
                ],
            ]);
        } else {
            return redirect()->route('lawyer.detil')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal Memperbarui Data Kantor',
                    'message' => 'Kantor tidak ditemukan',
                ],
            ]);
        }
    }

    public function updateWebsite(Request $request)
    {
        // Fetch the authenticated user
        $user = Auth::user();
        // Find the office record for the user
        $office = Office::where('user_id', $user->id)->first();
    
        if ($office) {
            // Validate the request data
            $validated = $request->validate([
                'aboutMe_title' => 'required|string|max:255',
                'aboutMe_description' => 'required|string|max:255',
                'slogan' => 'required|string|max:255',
                'tagLine' => 'required|string|max:255',
            ]);
    
            // Update the slogan in the Office table
            $office->update([
                'slogan' => $validated['slogan'],
            ]);
    
            // Find the office site record or create a new one
            $officeSite = OfficeSite::firstOrNew(['office_id' => $office->id]);
    
            // Update the record with the validated data
            $officeSite->aboutMe_title = $validated['aboutMe_title'];
            $officeSite->aboutMe_description = $validated['aboutMe_description'];
            $officeSite->tagline = $validated['tagLine'];
    
            // Save the record
            $officeSite->save();
    
            // Redirect back with a success message
            return redirect()->route('lawyer.website')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Data kantor telah diperbarui',
                ],
            ]);            
        } else {
            return redirect()->route('lawyer.website')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Eror',
                    'message' => 'Office record not found.',
                ],
            ]);
       
        }
    }
    

    public function officeAskverified(Request $request)
    {
        try {
            DB::beginTransaction();
           
            $userId = Auth::id();
               
            $officeMember = OfficeMember::where('id_user', $userId)->firstOrFail();
             
            $officeId = $officeMember->id_office;
    
            // Menghasilkan token acak
            $token = Str::random(40);
    
            // Membuat entri baru di tabel 'office_verification_lists'
            DB::table('office_verification_lists')->insert([
                'user_id' => $userId,
                'office_id' => $officeId,
                'status' => 1, // Misalkan, status awal adalah 1 (Ask Verified)
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Memperbarui status kantor (office) dari 0 menjadi 1
            $office = Office::find($officeId);
            if (!$office) {
                throw new \Exception('Office not found.');
            }
            $office->status = 1;
            $office->save();
    
            OfficeActivity::create([
                'office_id' => $officeId,
                'name' => 'Verification Request',
                'description' => 'has submitted',
                'badge' => 'info',
                'status' => '1',
            ]);
    
            // Mengambil data admin (user dengan id 1) dari database
            $admin = User::find(1);
    
            // Memeriksa apakah data admin ditemukan
            if ($admin) {
                // Mengirim notifikasi email ke admin
                $admin->notify(new OfficeVerificationRequestNotification($office, $token));
            } else {
                throw new \Exception('Admin not found.');
            }
    
            DB::commit();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Permohonan Verifikasi Berhasil Dikirim',
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Gagal Verifikasi. ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function officeDocuments(Request $request)
    {
        $request->validate([
            'group-a.*.document_name' => 'required|string|max:255',
            'group-a.*.document_file' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $office = Office::where('user_id', $user->id)->first();

        if ($office) {
            DB::beginTransaction();

            try {
                if ($request->hasFile('group-a.*.document_file')) {
                    $documents = [];
                    foreach ($request->input('group-a') as $key => $group) {
                        if ($request->hasFile("group-a.$key.document_file")) {
                            $file = $request->file("group-a.$key.document_file");
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $filePath = public_path('assets/img/office/document/' . $fileName);
                            
                            $file->move(public_path('assets/img/office/document'), $fileName);

                            $documents[] = [
                                'office_id' => $office->id,
                                'name' => $group['document_name'],
                                'file' => $fileName,
                                'url' => null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }

                    OfficeDocument::insert($documents);

                    // Tambahkan aktivitas kantor
                    OfficeActivity::create([
                        'office_id' => $office->id,
                        'name' => 'Dokumen Ditambahkan',
                        'description' => 'Dokumen kantor baru telah ditambahkan.',
                        'badge' => 'info',
                        'status' => '1',
                    ]);

                    DB::commit();

                    return redirect()->back()->with([
                        'response' => [
                            'success' => true,
                            'title' => 'Berhasil',
                            'message' => 'Dokumen berhasil disimpan',
                        ],
                    ]);
                } else {
                    DB::rollBack();
                    return redirect()->back()->with([
                        'response' => [
                            'success' => false,
                            'title' => 'Gagal',
                            'message' => 'Tidak ada dokumen yang diunggah',
                        ],
                    ]);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Gagal',
                        'message' => 'Terjadi kesalahan saat menyimpan dokumen',
                    ],
                ]);
            }
        }

        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Kantor tidak ditemukan',
            ],
        ]);
    }

    public function officeUpperkara(Request $request)
    {
     
        DB::beginTransaction();

        try {
            // Create a new OfficeCase record
            OfficeCase::create([
                'legal_case_id' => $request->input('kategori'),
                'office_id' => $request->input('office_id'),
                'min_fee' => str_replace('.', '', $request->input('min_biaya')),
                'max_fee' => str_replace('.', '', $request->input('max_biaya')),
            ]);

            // Commit the transaction
            DB::commit();
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Data berhasil ditambahkan.',
                ],
            ]);            
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollback();
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Terjadi Kesalahan Sistem',
                ],
            ]);
        }
    }

    public function destroy($id)
    {
        $document = OfficeDocument::find($id);

        if (!$document) {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Dokumen tidak ditemukan.',
                ],
            ]);
        }

        // Hapus file fisik jika perlu
        $filePath = public_path('assets/img/office/document/' . $document->file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Catat aktivitas kantor
        OfficeActivity::create([
            'office_id' => $document->office_id,
            'name' => 'Penghapusan Dokumen',
            'description' => 'Dokumen ' . $document->name . ' telah dihapus.',
            'badge' => 'danger',
            'status' => 1,
        ]);

        // Hapus data dokumen dari database
        $document->delete();      

        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Dokumen berhasil dihapus.',
            ],
        ]);
    }

    public function updateOfficeCase(Request $request, $id)
    {
        // Clean the input values
        $min_fee_cleaned = preg_replace('/[^0-9]/', '', $request->min_fee);
        $max_fee_cleaned = preg_replace('/[^0-9]/', '', $request->max_fee);

        // Validate the cleaned input values
        $request->merge(['min_fee' => $min_fee_cleaned, 'max_fee' => $max_fee_cleaned]);
        $request->validate([
            'min_fee' => 'required|numeric',
            'max_fee' => 'required|numeric',
        ]);

        // Update the OfficeCase with cleaned values
        $officeCase = OfficeCase::find($id);
        $officeCase->min_fee = $request->min_fee;
        $officeCase->max_fee = $request->max_fee;
        $officeCase->save();

        return response()->json([
            'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Biaya Perkara telah diperbarui',
            ]
        ]);
    }

    public function deleteOfficeCase(Request $request)
    {
        $id = $request->input('id');
        $officeCase = OfficeCase::find($id);
    
        if ($officeCase) {
            $officeCase->delete();
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Perkara & Biaya Berhasil Dihapus',
                ],
            ]);
        }
    
        return redirect()->back()->with('response', [
            'success' => false,
            'title' => 'Error',
            'message' => 'Office case could not be found.'
        ]);
    }
    
//Website
    public function addWebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'websiteName' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Validation Error',
                    'message' => $validator->errors()->first(),
                ]
            ])->withInput();
        }

        // URL encode the websiteName to replace spaces with +
        $encodedWebsiteName = str_replace([' ', '-'], '+', $request->websiteName);

        // Start a database transaction
        DB::beginTransaction();

        try {
            if (Office::where('website', $encodedWebsiteName)->exists()) {
                DB::rollBack();
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'URL Exists',
                        'message' => 'URL sudah ada. Silakan pilih nama lain.',
                    ]
                ])->withInput();
            }

            // Find the office by id using where
            $office = Office::where('id', $request->office_id)->first();

            // Check if the office is null
            if (!$office) {
                DB::rollBack();
                return redirect()->back()->with([
                    'response' => [
                        'success' => false,
                        'title' => 'Office Not Found',
                        'message' => 'Kantor tidak ditemukan.',
                    ]
                ])->withInput();
            }

            // Log the office details to verify the name attribute
            Log::info('Office Details: ', $office->toArray());

            // Update the office website field
            $office->website = $encodedWebsiteName;
            $office->save();

            // Create a new OfficeSite record with default values
            OfficeSite::create([
                'office_id' => $office->id,
                'office_name' => $encodedWebsiteName,
                'logo_image' => 'logo_default.png', // Default value
                'owner_image' => 'default-image.webp', // Default value
                'owner_sec_image' => 'default-image.webp', // Default value
                'icon_image' => 'icon_default.webp',
                'tagline' => 'Default Tagline', // Default value
                'aboutMe_title' => 'Default About Me Title', // Default value
                'aboutMe_description' => 'Default About Me Description', // Default value
                'aboutMe_legalcategory' => json_encode(['Default Category']), // Default value
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Nama page berhasil ditambahkan.',
                ]
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => $e->getMessage(),
                ]
            ])->withInput();
        }
    }

    public function storeGallery(Request $request)
    {
        // Validate input
        $request->validate([
            'shortTitle' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'imageFile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $userId = Auth::id();
        $officeMember = OfficeMember::where('id_user', $userId)->firstOrFail();
        $office = Office::where('id', $officeMember->id_office)->first();
    
        if ($office) {
            $file = $request->file('imageFile');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $newName = Str::random(12) . '.webp';
    
            $file->move('temp', $imageName);
    
            $imgManager = new ImageManager(new Driver());
            $gallery = $imgManager->read('temp/' . $imageName);
            $encodedImage = $gallery->encode(new WebpEncoder(quality: 65));
            $encodedImage->save(public_path('assets/img/office/site/'. $newName));
            unlink('temp/' . $imageName);

            // Save gallery entry
            OfficeGallery::create([
                'short_title' => $request->input('shortTitle'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image_file' => $newName,
                'office_id' => $office->id,
            ]);

            OfficeActivity::create([
                'office_id' => $office->id,
                'name' => 'Gallery Updated',
                'description' => 'The office gallery has been updated.',
                'badge' => 'primary',
                'status' => '1',
            ]);

            return redirect()->route('lawyer.website')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Gallery ditambahkan',
                ],
            ]);
        }
    }

    public function checkWebsite(Request $request)
    {
        $websiteName = str_replace([' ', '-'], '+', $request->query('websiteName'));

        $exists = Office::where('website', $websiteName)->exists();

        return response()->json(['exists' => $exists]);
    }
//!Website
//Editing
//Get Data
    public function getCase()
    {
        $categories = LegalCase::select('id', 'name', 'kategori')->distinct()->get();
        return response()->json($categories);
    }

    public function getPerkaraData(Request $request, $office_id)
    {
        if ($request->ajax()) {
            $data = OfficeCase::with('legalCase', 'office')
                ->where('office_id', $office_id)
                ->select('office_cases.*');

            return DataTables::of($data)
                ->addColumn('no', function () {
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })
                ->addColumn('perkara', function($row){
                    return $row->legalCase->name;
                })
                ->addColumn('min_biaya', function($row){
                    return number_format($row->min_fee, 0, ',', '.');
                })
                ->addColumn('max_biaya', function($row){
                    return number_format($row->max_fee, 0, ',', '.');
                })
                ->addColumn('rata_rata', function($row){
                    return number_format(($row->min_fee + $row->max_fee) / 2, 0, ',', '.');
                })
                ->addColumn('action', function($row){
                    $editIcon = '<a href="#" class="text-body edit" data-id="' . $row->id . '" data-perkara="' . $row->legalCase->name . '" data-minfee="' . $row->min_fee . '" data-maxfee="' . $row->max_fee . '">' .
                                '<i class="bx bxs-message-square-edit mx-1"></i>' .
                                '</a>';
                    $deleteIcon = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'' . route('deleteOfficeCase', ['id' => $row->id]) . '\', \'Hapus Perkara: ' . $row->legalCase->name . ' ?\')">' .
                                '<i class="bx bx-trash"></i>' .
                                '</a>';
                
                    return '<div class="d-flex align-items-center">' .
                            $editIcon .
                            $deleteIcon .
                            '</div>';
                }) 
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    private function determineLabel($averageFee)
    {
        if ($averageFee <= 50000000) {
            return 1; // $
        } elseif ($averageFee <= 80000000) {
            return 2; // $$
        } elseif ($averageFee <= 100000000) {
            return 3; // $$$
        } elseif ($averageFee <= 200000000) {
            return 4; // $$$$
        } else {
            return 5; // $$$$$
        }
    }
//!Get Data

}
