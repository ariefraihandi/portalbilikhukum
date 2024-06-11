<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\OfficeVerificationList;
use App\Models\Office;
use App\Models\OfficeActivity;
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
            'title'             => 'Lawyer List',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $request->get('accessMenus'),            
        ];
        return view('Portal.Bisnis.lawyerList', $data);        
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
    

    
    public function getAllOffice(Request $request)
    {
        if ($request->ajax()) {
            $type                       = $request->input('Type');
            $status                     = $request->input('Status');

            $start_date                 = $request->input('start_date');
            $end_date                   = $request->input('end_date');           
                      
            $query = Office::with('user')->orderByDesc('created_at');
                    
            if ($type != '') {
                $query->where('type', $type);
            }
        
            if ($status != '') {
                $query->where('status', $status);
            }
            
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);   
            }
            
            // Ambil data sesuai dengan query yang telah dibuat
            $offices = $query->get();
            $counter = 0; // Initialize counter variable
            return DataTables::of($offices)
                ->addColumn('no', function ($office) use (&$counter) {
                    $counter++; // Increment the counter for each row
                    return $counter; // Return the current value of the counter
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
                    // Get the address components
                    $alamat = $office->alamat;
                    $desa = $office->village ? $office->village->name : 'Unknown village';
                    $kecamatan = $office->district ? $office->district->name : 'Unknown district';
                    $kabupaten_kota = $office->regency ? $office->regency->name : 'Unknown regency';
                    $provinsi = $office->province ? $office->province->name : 'Unknown province';
                
                    // Concatenate address
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
                    $created->locale('id'); // Set locale to Indonesian
                    $formattedDate = $created->translatedFormat('d F Y');
                    
                    return $formattedDate;
                })
                ->addColumn('klien', function ($office) {
                    $created = Carbon::parse($office->created_at);
                    $created->locale('id'); // Set locale to Indonesian
                    $formattedDate = $created->translatedFormat('d F Y');
                    
                    return $formattedDate;
                })
                ->addColumn('profit', function ($office) {
                    $created = Carbon::parse($office->created_at);
                    $created->locale('id'); // Set locale to Indonesian
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
                            // Creating the URL directly in HTML using an anchor tag
                            if ($office->officeVerificationList) {
                                $url = '/bisnis/office/verify?token=' . $office->officeVerificationList->token . '&user_id=' . $office->user_id . '&office_id=' . $office->id;
                                $statusText = '<a href="' . $url . '" class="' . $badgeClass . '" style="color: inherit; text-decoration: none;">' . $statusText . '</a>';
                            } else {
                                // If no verification list exists, just display the text without a link
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
                
                    // Return the badge HTML
                    return '<div class="text-center"><span class="badge ' . $badgeClass . '">' . $statusText . '</span></div>';
                })
                ->addColumn('action', function ($office) {
                    $officeNumber = $office->office_number;
                    $uuid = $office->customer_uuid;
                
                    return '<div class="d-flex align-items-center">' .
                                '<a href="/office/add?officeNumber=' . $officeNumber . '&customerUuid=' . $uuid . '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Edit"><i class="bx bxs-message-square-edit mx-1"></i></a>' .
                                '<a href="/delete-office?officeNumber=' . $officeNumber . '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Hapus" onclick="return confirmDelete(\'/delete-office?officeNumber=' . $officeNumber . '\')"><i class="bx bx-trash mx-1"></i></a>' .
                                '<div class="dropdown">' .
                                '<a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' .
                                '<div class="dropdown-menu dropdown-menu-end">' .
                                '<a href="/print/' . $officeNumber .'" class="dropdown-item" target="_blank">Download</a>' .
                                '<a href="/send-office?officeNumber=' . $officeNumber . '&customerUuid=' . $uuid . '" class="dropdown-item">Kirim office</a>' .                                
                                '</div>' .
                                '</div>' .
                            '</div>';
                })
                ->rawColumns(['nama_kantor', 'alamat', 'status', 'action'])
                ->make(true); 
        }
    }
}
