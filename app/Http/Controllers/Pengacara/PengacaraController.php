<?php

namespace App\Http\Controllers\Pengacara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;

class PengacaraController extends Controller
{
    public function showIndex()
    {
        $referedBy = 'ariefraihandi';
        $title = 'Cari Pengacara';
        $subTitle = 'Bilik Hukum';
    
        $data = [
            'referedBy' => $referedBy,
            'title' => $title,
            'subTitle' => $subTitle,
            // Tambahkan variabel lain ke array $data
        ];

        return view('Pengacara.cariPengacara', compact('data'));
        
    }


    public function search(Request $request)
    {
        // Pastikan permintaan adalah permintaan AJAX
        if ($request->ajax()) {
            // Lakukan pencarian berdasarkan data yang diterima dari request
            $searchTerm = $request->input('search');
        
            // Lakukan pencarian di kedua tabel provinces dan regencies
            $provinces = Province::where('name', 'like', "%$searchTerm%")->get();
            $regencies = Regency::where('name', 'like', "%$searchTerm%")->get();
        
            // Gabungkan hasil pencarian dari kedua tabel menjadi satu array
            $results = [];
            foreach ($provinces as $province) {
                $results[] = ['value' => $province->name, 'text' => $province->code];
            }
            foreach ($regencies as $regency) {
                $results[] = ['value' => $regency->name, 'text' => $regency->code];
            }
        
            // Kembalikan hasil pencarian sebagai respons JSON
            return response()->json($results);
        } else {
            // Jika bukan permintaan AJAX, kembalikan respons dengan kode status yang sesuai
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
