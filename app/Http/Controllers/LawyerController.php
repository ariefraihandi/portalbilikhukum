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
use App\Models\OfficeDocument;
use App\Models\Office;
use App\Models\User;
use App\Models\OfficeVerificationList;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use App\Notifications\OfficeVerificationRequestNotification;

class LawyerController extends Controller
{
    public function showLawyer(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId = $officeMember->id_office;
            
            $office             = Office::find($officeId);
            $joinedDate         = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $officeActivities   = OfficeActivity::where('office_id', $office->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();
            $officeDocuments    = OfficeDocument::where('office_id', $officeId)->get();

            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeActivities'  => $officeActivities,
                'officeDocuments'   => $officeDocuments,
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
            $officeId           = $officeMember->id_office;
            $office             = Office::where('type', 1)->find($officeId);            
            $joinedDate         = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $OfficeActivity     = OfficeActivity::where('office_id', $officeId)->get();
            $officeDocuments    = OfficeDocument::where('office_id', $officeId)->get();

            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeActivities'  => $OfficeActivity,
                'officeDocuments'   => $officeDocuments,
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

        // Mengambil ID pengguna yang saat ini login
        $userId = Auth::id();

        // Mencari baris OfficeMember yang memiliki ID pengguna yang sesuai dengan ID pengguna yang sedang login
        $officeMember = OfficeMember::where('id_user', $userId)->firstOrFail();

        // Mengambil ID kantor (office) yang terkait
        $officeId = $officeMember->id_office;

        // Membuat entri baru di tabel 'office_verification_lists'
        DB::table('office_verification_lists')->insert([
            'user_id' => $userId,
            'office_id' => $officeId,
            'status' => 1, // Misalkan, status awal adalah 1 (Ask Verified)
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Memperbarui status kantor (office) dari 0 menjadi 2
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
        $admin->notify(new OfficeVerificationRequestNotification($office));
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
//Editing
}