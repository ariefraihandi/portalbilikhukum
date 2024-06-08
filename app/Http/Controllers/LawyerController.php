<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OfficeMember;
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
            $office = Office::find($officeId);
            $joinedDate = Carbon::parse($office->created_at)->translatedFormat('F Y');

            // Kemudian Anda dapat mengirimkan ID kantor ke view
            $data = [
                'title' => 'Pengacara',
                'subtitle' => 'Bilik Hukum',
                'sidebar' => $request->get('accessMenus'),
                'office' => $office,
                'joinedDate' => $joinedDate,
            ];

            return view('Portal.Pengacara.index', $data);
        } else {
            // Jika tidak ditemukan, berikan tanggapan atau tindakan yang sesuai
            return response()->json(['error' => 'Anda belum terdaftar sebagai anggota kantor.']);
        }
    }
}
