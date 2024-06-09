<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use DataTables;
use Carbon\Carbon;

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
