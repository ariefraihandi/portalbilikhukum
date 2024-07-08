<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\OfficeVerificationList;
use App\Models\Office;
use App\Models\User;
use App\Models\OfficeActivity;
use App\Models\RefferalCode;
use App\Models\OfficeDocument;
use DataTables;
use Carbon\Carbon;
use App\Mail\OfficeVerified;

class BisnisController extends Controller
{
    public function showOfficeList(Request $request)
    {
        $data = [
            'title'             => 'Lawyer List',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $request->get('accessMenus'),            
        ];
        return view('Portal.Bisnis.lawyerList', $data);        
    }
    
    public function showUserList(Request $request)
    {
        $data = [
            'title'             => 'Member List',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $request->get('accessMenus'),            
        ];
        return view('Portal.Bisnis.memberList', $data);        
    }
    
    public function showOfficeVerify(Request $request)
    {
        // Mendapatkan user_id dan office_id dari URL
        $user_id        = $request->query('user_id');
        $office_id      = $request->query('office_id');
        $token          = $request->query('token');

        if (config('app.url') === 'http://localhost') {
            // Application is running in a local environment
            $url = "http://127.0.0.1:8000/";
        } else {
            // Application is running on the server
            $url = "https://bilikhukum.com/";
        }

        $officeVerification = OfficeVerificationList::where('user_id', $user_id)
                                                     ->where('office_id', $office_id)
                                                     ->first();

        // Mengecek apakah data ditemukan
        if ($officeVerification) {
            // Ambil data office
            $office                 = $officeVerification->office;
            $officeDocuments        = $office->documents;

            // Siapkan data untuk view
            $data = [
                'title'             => 'Lawyer Verify',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'officeDocuments'   => $officeDocuments,
                'token'             => $token,
                'office_id'         => $office_id,
                'user_id'           => $user_id,
                'url'               => $url,
            ];

            return view('Portal.Bisnis.verifyOffice', $data);
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Office verification not found',
                ],
            ]);
            return redirect()->back()->with('error', 'Office verification not found');
        }
    }
    
    public function officeVerify(Request $request)
    {
        $user_id   = $request->query('user_id');
        $office_id = $request->query('office_id');
        $token     = $request->query('token');
    
        try {
            // Check if the record exists
            $verification = OfficeVerificationList::where('user_id', $user_id)
                ->where('office_id', $office_id)
                ->where('token', $token)
                ->first();
    
            if ($verification) {
                // Get office id and delete the verification record
                $office_id = $verification->office_id;
                $verification->delete();
    
                // Update the status of the office
                $office = Office::find($office_id);
                if ($office) {
                    $office->status = 2;
                    $office->save();
    
                    // Send email notification
                    Mail::to($office->email_kantor)->send(new OfficeVerified($office));
    
                    // Create office activity
                    OfficeActivity::create([
                        'office_id' => $office_id,
                        'name' => 'Verification Success',
                        'description' => 'Verifikasi sudah disetujui',
                        'badge' => 'success',
                        'status' => '1',
                    ]);
                }
    
                // Get all documents related to the office
                $documents = OfficeDocument::where('office_id', $office_id)->get();
                foreach ($documents as $document) {
                    // Unlink (delete) the document file from the file system
                    $filePath = public_path('assets/img/office/document/' . $document->file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                    // Delete the document record from the database
                    $document->delete();
                }
    
                // Redirect with success message
                return redirect()->route('bisnis.office.list')->with([
                    'response' => [
                        'success' => true,
                        'title'   => 'Success',
                        'message' => 'Office verification successful.',
                    ],
                ]);
            } else {
                // Redirect with error message if verification record not found
                return redirect()->route('bisnis.office.list')->with([
                    'response' => [
                        'success' => false,
                        'title'   => 'Error',
                        'message' => 'Verification record not found.',
                    ],
                ]);
            }
        } catch (\Exception $e) {
            // Redirect with error message in case of exception
            return redirect()->route('bisnis.office.list')->with([
                'response' => [
                    'success' => false,
                    'title'   => 'Error',
                    'message' => 'Failed to verify office. ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function officeUpdateDoc(Request $request)
    {
        // Validasi input
        $request->validate([
            'documents.*.id' => 'required|exists:office_documents,id',
            'documents.*.url' => 'nullable|url',
        ]);
    
        // Dapatkan data dokumen dari input
        $documentsData = $request->input('documents', []);
        $office_id = $request->input('office_id');
        $user_id = $request->input('user_id');
        $token = $request->input('token');
    
        DB::beginTransaction();
    
        try {
            foreach ($documentsData as $data) {
                $document = OfficeDocument::find($data['id']);
                if ($document) {
                    // Hapus file lama dari sistem file jika ada
                    $filePath = public_path('assets/img/office/document/' . $document->file);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
    
                    // Simpan URL baru
                    if (!empty($data['url'])) {
                        $document->url = $data['url'];                     
                    } else {
                        // Handle case where URL is not provided
                        $document->url = null;
                    }
                    $document->save();
                }
            }
    
            $verification = OfficeVerificationList::where('office_id', $office_id)
                ->where('office_id', $office_id)          
                ->first();
    
            if ($verification) {
                $verification->status = 2;
                $verification->save();
            }
    
            $office = Office::find($office_id);
            if ($office) {
                $office->status = 2;
                $office->save();
    
                // Kirim email notifikasi
                Mail::to($office->email_kantor)->send(new OfficeVerified($office));
    
                // Buat aktivitas office
                OfficeActivity::create([
                    'office_id' => $office_id,
                    'name' => 'Verification Success',
                    'description' => 'Verifikasi sudah disetujui',
                    'badge' => 'success',
                    'status' => '1',
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('bisnis.office.list')->with([
                'response' => [
                    'success' => true,
                    'title'   => 'Success',
                    'message' => 'Office verification successful.',
                ],
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            // Redirect dengan pesan error jika terjadi exception
            return redirect()->route('bisnis.office.list')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Failed to verify office. ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function destroy($id)
    {
        // Find the office by id and delete it
        $office = Office::find($id);

        if ($office) {
            $office->delete();
            return redirect()->route('bisnis.office.list')->with([
                'response' => [
                    'success' => true,
                    'title'   => 'Success',
                    'message' => 'Kantor Berhasil Dihapus.',
                ],
            ]);
        } else {
            return redirect()->route('bisnis.office.list')->with([
                'response' => [
                    'success' => false,
                    'title'   => 'Gagal',
                    'message' => 'Kantor Gagal Dihapus.',
                ],
            ]);
        }
    }

    public function destroyAccount(Request $request)
    {
        $id = $request->query('id');
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title'   => 'Success',
                    'message' => 'Account and all related data deleted successfully.',
                ],
            ]);          
        } else {
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title'   => 'Failed',
                    'message' => 'User not found.',
                ],
            ]);              
        }
    }
    
    public function getAllMember(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->input('Type');
            $status = $request->input('Status');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            // Query untuk mengambil data user
            $query = User::orderByDesc('created_at');

            if ($type) {
                $query->where('role', $type);
            }

            if ($status) {
                $query->where('verified', $status);
            }

            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }

            $users = $query->get();
            $counter = 0;

            return DataTables::of($users)
                ->addColumn('no', function ($user) use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('member', function ($user) {
                    $userImage = $user->image ? asset('assets/img/member/' . $user->image) : asset('assets/img/default-image.jpg');
                    $userName = $user->name ?? 'Unknown User';
                    $userEmail = $user->email ?? 'Unknown Email';
                    $userWhatsApp = ($user->whatsapp && !in_array($user->whatsapp, ['default_value', '08xxxxxxxxxx'])) ? e($user->whatsapp) : '';
                    $userSince = Carbon::parse($user->created_at)->format('d F Y');
                
                    // Format output
                    $output = '
                        <div class="d-flex align-items-center">
                            <img src="' . $userImage . '" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <span class="fw-bold">' . e($userName) . '</span>
                                <small class="text-muted d-block">' . e($userEmail) . '</small>';
                    if ($userWhatsApp) {
                        $output .= '<small class="text-muted d-block">' . $userWhatsApp . '</small>';
                    }
                    $output .= '<small class="text-muted d-block">Since: ' . $userSince . '</small>
                            </div>
                        </div>';
                
                    return $output;
                })            
                ->addColumn('type', function ($user) {
                    $role = $user->role;
                    $icon = '';
                    $labelClass = '';
                    $roleName = '';
                
                    // Menentukan ikon, warna label, dan nama peran berdasarkan role
                    switch ($role) {
                        case 1:
                            $icon = '<i class="bx bxs-castle"></i>';
                            $labelClass = 'bg-label-primary';
                            $roleName = 'Administrator';
                            break;
                        case 2:
                            $icon = '<i class="bx bxs-cog"></i>';
                            $labelClass = 'bg-label-secondary';
                            $roleName = 'Admin';
                            break;
                        case 3:
                            $icon = '<i class="bx bxs-user"></i>';
                            $labelClass = 'bg-label-info';
                            $roleName = 'Member';
                            break;
                        case 4:
                            $icon = '<i class="bx bxs-briefcase"></i>';
                            $labelClass = 'bg-label-success';
                            $roleName = 'Pengacara';
                            break;
                        case 5:
                            $icon = '<i class="bx bxs-file-doc"></i>';
                            $labelClass = 'bg-label-warning';
                            $roleName = 'Notaris';
                            break;
                        case 6:
                            $icon = '<i class="bx bxs-hand"></i>';
                            $labelClass = 'bg-label-danger';
                            $roleName = 'Mediator';
                            break;
                        default:
                            $icon = '<i class="bx bxs-question-mark"></i>';
                            $labelClass = 'bg-label-dark';
                            $roleName = 'Unknown';
                            break;
                    }
                
                    // Ambil bagian alamat
                    $addressParts = $user->getAddressParts();
                    $villageName = $addressParts['village'] ? $user->capitalizeWords($addressParts['village']->name) : null;
                    $districtName = $addressParts['district'] ? $user->capitalizeWords($addressParts['district']->name) : null;
                    $regencyName = $addressParts['regency'] ? $user->capitalizeWords($addressParts['regency']->name) : null;
                    $provinceName = $addressParts['province'] ? $user->capitalizeWords($addressParts['province']->name) : null;
                
                    // Gabungkan alamat jika ada, atau tampilkan "Not Set"
                    $address = 'Not Set';
                    if ($villageName || $districtName || $regencyName || $provinceName) {
                        $addressArray = array_filter([$villageName, $districtName, $regencyName, $provinceName]);
                        $address = implode(', ', $addressArray);
                    }
                
                    // Format output untuk menampilkan peran dan alamat
                    return '
                        <div>
                            <span class="badge badge-center rounded-pill ' . $labelClass . ' w-px-30 h-px-30 me-2">
                                ' . $icon . '
                            </span>
                            <span class="align-middle">' . $roleName . '</span>
                            <div class="text-muted small">' . $address . '</div>
                        </div>';
                })            
                ->addColumn('refered_by', function ($user) {
                    // Cari data refferal code berdasarkan kode referal
                    $refferalCode = RefferalCode::where('code', $user->referedby)->first();
                    
                    // Jika ada refferal code, ambil user_id
                    if ($refferalCode) {
                        $user_id = $refferalCode->user_id;
                        // Cari pengguna berdasarkan user_id yang diambil dari refferal code
                        $referrer = User::find($user_id);
                
                        if ($referrer) {
                            $referrerName = e($referrer->name);
                            $referrerRole = $referrer->role;
                            $icon = '';
                            $labelClass = '';
                            $roleName = '';
                
                            // Tentukan ikon, warna label, dan nama peran berdasarkan role
                            switch ($referrerRole) {
                                case 1:
                                    $icon = '<i class="bx bxs-castle"></i>';
                                    $labelClass = 'bg-label-primary';
                                    $roleName = 'Administrator';
                                    break;
                                case 2:
                                    $icon = '<i class="bx bxs-cog"></i>';
                                    $labelClass = 'bg-label-secondary';
                                    $roleName = 'Admin';
                                    break;
                                case 3:
                                    $icon = '<i class="bx bxs-user"></i>';
                                    $labelClass = 'bg-label-info';
                                    $roleName = 'Member';
                                    break;
                                case 4:
                                    $icon = '<i class="bx bxs-briefcase"></i>';
                                    $labelClass = 'bg-label-success';
                                    $roleName = 'Pengacara';
                                    break;
                                case 5:
                                    $icon = '<i class="bx bxs-file-doc"></i>';
                                    $labelClass = 'bg-label-warning';
                                    $roleName = 'Notaris';
                                    break;
                                case 6:
                                    $icon = '<i class="bx bxs-hand"></i>';
                                    $labelClass = 'bg-label-danger';
                                    $roleName = 'Mediator';
                                    break;
                                default:
                                    $icon = '<i class="bx bxs-question-mark"></i>';
                                    $labelClass = 'bg-label-dark';
                                    $roleName = 'Unknown';
                                    break;
                            }
                
                            return '
                                <div>
                                    <span>' . $referrerName . '</span>
                                    <div>
                                        <span class="badge badge-center rounded-pill ' . $labelClass . ' w-px-20 h-px-20 me-2">
                                            ' . $icon . '
                                        </span>
                                        <span class="align-middle">' . $roleName . '</span>
                                    </div>
                                </div>';
                        }
                    }
                    return 'N/A';
                })        
                ->addColumn('status', function ($user) {
                    return $user->verified ? 'Yes' : 'No';
                })     
                ->addColumn('referring', function ($user) {
                    // Cari data RefferalCode berdasarkan user_id
                    $refferalCode = RefferalCode::where('user_id', $user->id)->first();
                
                    if ($refferalCode) {
                        // Hitung jumlah pengguna yang menggunakan kode referral ini
                        $referralCount = User::where('referedby', $refferalCode->code)->count();
                        return $referralCount . ' Users';
                    } else {
                        return 'No referrals';
                    }
                })
                ->addColumn('profit', function ($user) {
                    // Contoh pengolahan data profit jika ada
                    return number_format($user->profit, 2, ',', '.');
                })         
                ->addColumn('action', function ($user) {
                    // Format nomor WhatsApp
                    $whatsappNumber = $user->whatsapp;
                    if (strpos($whatsappNumber, '62') === 0) {
                        // Jika dimulai dengan 62, biarkan
                    } elseif (strpos($whatsappNumber, '08') === 0) {
                        // Jika dimulai dengan 08, ubah 0 ke 62
                        $whatsappNumber = '62' . substr($whatsappNumber, 1);
                    } elseif (strpos($whatsappNumber, '8') === 0) {
                        // Jika dimulai dengan 8, tambahkan 62
                        $whatsappNumber = '62' . $whatsappNumber;
                    }
                
                    return '
                        <div class="d-flex align-items-center">
                            <a href="/user/edit/' . $user->id . '" class="text-primary me-2" title="Edit">
                                <i class="bx bx-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="text-danger me-2" title="Delete" onclick="showDeleteConfirmation(\'/account/delete/?id=' . $user->id . '\', \'This action cannot be undone.\')">
                                <i class="bx bx-trash"></i>
                            </a>
                            <a href="https://wa.me/' . $whatsappNumber . '" class="text-success" title="WhatsApp" target="_blank">
                                <i class="bx bxl-whatsapp"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['member', 'type', 'refered_by', 'status', 'action'])
                ->make(true);
        }
    }


    public function changeStatus(Request $request)
    {
        $officeId = $request->input('id');
        $office = Office::find($officeId);

        if ($office) {
            // Toggle status logic
            // If the current status is greater than 0, change it to 0. Otherwise, change it to 2.
            $office->status = $office->status > 0 ? 0 : 2;
            $office->save();

            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title'   => 'Berhasil',
                    'message' => 'Status sudah di ubah.',
                ],
            ]);
        }

        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title'   => 'Gagal',
                'message' => 'Office tidak ditemukan.',
            ],
        ]);
    }


    public function getAllOffice(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->input('Type');
            $status = $request->input('Status');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');           
    
            $query = Office::with('user')
                ->withCount('klienChats') // Add this line to count clients
                ->orderByDesc('created_at');
    
            if ($type != '') {
                $query->where('type', $type);
            }
    
            if ($status != '') {
                $query->where('status', $status);
            }
    
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);   
            }
    
            $offices = $query->get();
            $counter = 0;
    
            return DataTables::of($offices)
                ->addColumn('no', function ($office) use (&$counter) {
                    $counter++;
                    return $counter;
                })
                ->addColumn('nama_kantor', function ($office) {
                    $officeName = $office->nama_kantor;
                    $officeMail = $office->email_kantor;
                    $officeWa = $office->hp_whatsapp;
                    $ownerImage = $office->user->image;
                    $typeText = '';
    
                    if ($office->type == 1) {
                        $typeText = 'Pengacara';
                    } elseif ($office->type == 2) {
                        $typeText = 'Notaris';
                    } elseif ($office->type == 3) {
                        $typeText = 'Mediator';
                    } else {
                        $typeText = 'Unknown';
                    }
    
                    $output = '<div class="d-flex justify-content-start align-items-center customer-name">' .
                              '<div class="avatar-wrapper">' .
                              '<div class="avatar me-2">' .
                              '<img src="' . asset('assets/img/member/' . $ownerImage) . '" alt="Avatar" class="rounded-circle">' .
                              '</div>' .
                              '</div>' .
                              '<div class="d-flex flex-column">' .
                              '<span class="fw-medium">' . $typeText . ' ' . $officeName . '</span>' .
                              '<small class="text-muted">' . $officeMail . '</small>' .
                              '<small class="text-muted">' . $officeWa . '</small>' .
                              '</div>' .
                              '</div>';
    
                    return $output;
                })
                ->addColumn('alamat', function ($office) {
                    $alamat = $office->alamat;
                    $desa = $office->village ? $office->village->name : 'Unknown village';
                    $kecamatan = $office->district ? $office->district->name : 'Unknown district';
                    $kabupaten_kota = $office->regency ? $office->regency->name : 'Unknown regency';
                    $provinsi = $office->province ? $office->province->name : 'Unknown province';
    
                    $addressLine1 = $alamat . ', ' . $desa . ', ' . $kecamatan;
                    $addressLine2 = $kabupaten_kota . ', ' . $provinsi;
    
                    return '<div>' .
                           '<i class="bx bx-map"></i> ' .
                           '<span class="fw-medium">' . $addressLine1 . '</span><br>' .
                           '<small class="text-muted">' . $addressLine2 . '</small>' .
                           '</div>';
                })
                ->addColumn('since', function ($office) {
                    $created = Carbon::parse($office->created_at);
                    $created->locale('id');
                    $formattedDate = $created->translatedFormat('d F Y');
    
                    return $formattedDate;
                })
                ->addColumn('klien', function ($office) {
                    return $office->klien_chats_count; // This will output the count of clients
                })
                ->addColumn('profit', function ($office) {
                    $created = Carbon::parse($office->created_at);
                    $created->locale('id');
                    $formattedDate = $created->translatedFormat('d F Y');
    
                    return $formattedDate;
                })
                ->addColumn('status', function ($office) {
                    $statusText = '';
                    $badgeClass = '';
    
                    switch ($office->status) {
                        case 0:
                            $statusText = 'Not Verified';
                            $badgeClass = 'bg-label-warning';
                            break;
                        case 1:
                            $statusText = 'Ask Verified';
                            $badgeClass = 'bg-label-info';
                            if ($office->officeVerificationList) {
                                $url = '/bisnis/office/verify?token=' . $office->officeVerificationList->token . '&user_id=' . $office->user_id . '&office_id=' . $office->id;
                                $statusText = '<a href="' . $url . '" class="' . $badgeClass . '" style="color: inherit; text-decoration: none;">' . $statusText . '</a>';
                            } else {
                                $statusText = '<span class="' . $badgeClass . '" style="color: inherit;">' . $statusText . '</span>';
                            }
                            break;
                        case 2:
                            $statusText = 'Verified';
                            $badgeClass = 'bg-label-success';
                            break;
                        case 3:
                            $statusText = 'Suspended';
                            $badgeClass = 'bg-label-secondary';
                            break;
                        case 4:
                            $statusText = 'Blocked';
                            $badgeClass = 'bg-label-danger';
                            break;
                        default:
                            $statusText = 'Unknown';
                            $badgeClass = 'bg-label-dark';
                    }
    
                    return '<div class="text-center"><span class="badge ' . $badgeClass . '">' . $statusText . '</span></div>';
                })
                ->addColumn('action', function ($office) {
                    $officeId = $office->id;
                    $officeWa = $office->hp_whatsapp;
                    
                    // Modify the WhatsApp number
                    if (preg_match('/^0/', $officeWa)) {
                        $officeWa = preg_replace('/^0/', '62', $officeWa);
                    } elseif (preg_match('/^8/', $officeWa)) {
                        $officeWa = '62' . $officeWa;
                    }
                
                    // Determine active/inactive status
                    $activeStatus = $office->status == 2 ? 'active' : '';
                    $inactiveStatus = $office->status != 2 ? 'active' : '';
                    
                
                    return '<div class="d-flex align-items-center">' .
                        '<a href="/office/add?id=' . $officeId . '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Edit"><i class="bx bxs-message-square-edit mx-1"></i></a>' .
                        '<a href="javascript:void(0);" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Hapus" onclick="showDeleteConfirmation(\'/delete-office/' . $officeId . '\', \'Do you want to delete this office?\')"><i class="bx bx-trash mx-1"></i></a>' .
                        '<a href="https://wa.me/' . $officeWa . '" target="_blank" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Contact via WhatsApp"><i class="bx bxl-whatsapp mx-1"></i></a>' .
                        '<div class="dropdown">' .
                            '<a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' .
                            '<div class="dropdown-menu dropdown-menu-end">' .
                                '<a href="/bisnis/officestatus?id=' . $officeId . '" class="dropdown-item ' . $activeStatus . '"> Aktif </a>' .
                                '<a href="/bisnis/officestatus?id=' . $officeId . '" class="dropdown-item ' . $inactiveStatus . '"> Tidak Aktif </a>' .                               
                            '</div>' .
                        '</div>' .
                    '</div>';
                })          
                ->rawColumns(['nama_kantor', 'alamat', 'status', 'action'])
                ->make(true); 
        }
    }
    
}
