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
use App\Models\Office;
use App\Models\User;
use App\Models\OfficeVerificationList;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use App\Notifications\OfficeVerificationRequestNotification;
use DataTables;

class LawyerController extends Controller
{
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
            $user = Auth::user();
            $office = Office::where('user_id', $user->id)->first(); // Ambil data kantor dari ID user yang login

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

    public function officeUpdate(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'officeName' => 'required|string|max:255',
            'officeEmail' => 'required|email|max:255',
            'officePhone' => 'required|string|max:20',
            'officedesa' => 'required|string|max:255',
            'postCode' => 'required|string|max:10',
            'slogan' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
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
                'slogan' => $validatedData['slogan'],
                'website' => $validatedData['website'],
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
