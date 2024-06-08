<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMember;
use App\Models\OfficeActivity;
use App\Models\Office;
use Carbon\Carbon;

class LawyerController extends Controller
{
    public function showLawyer(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId = $officeMember->id_office;

            // Mengambil entri kantor dari tabel offices berdasarkan ID kantor yang ditemukan
            $office         = Office::find($officeId);
            $joinedDate     = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $OfficeActivity = OfficeActivity::where('office_id', $officeId)->get();
            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeActivities'  => $OfficeActivity,
            ];

            return view('Portal.Pengacara.index', $data);
        } else {
            // Jika tidak ditemukan, berikan tanggapan atau tindakan yang sesuai
            return response()->json(['error' => 'Anda belum terdaftar sebagai anggota kantor.']);
        }
    }
    
    public function showLawyerDetil(Request $request)
    {
        Carbon::setLocale('id');

        $userId         = Auth::id();
        $officeMember   = OfficeMember::where('id_user', $userId)->first();

        if ($officeMember) {
            $officeId = $officeMember->id_office;
            
            $office = Office::where('type', 1)->find($officeId);

            // dd($office);
            $joinedDate     = Carbon::parse($office->created_at)->translatedFormat('F Y');
            $OfficeActivity = OfficeActivity::where('office_id', $officeId)->get();
            $data = [
                'title'             => 'Pengacara',
                'subtitle'          => 'Bilik Hukum',
                'sidebar'           => $request->get('accessMenus'),
                'office'            => $office,
                'joinedDate'        => $joinedDate,
                'officeActivities'  => $OfficeActivity,
            ];

            return view('Portal.Pengacara.detilKantor', $data);
        } else {
            // Jika tidak ditemukan, berikan tanggapan atau tindakan yang sesuai
            return response()->json(['error' => 'Anda belum terdaftar sebagai anggota kantor.']);
        }
    }

}
