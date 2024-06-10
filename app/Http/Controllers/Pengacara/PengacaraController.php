<?php

namespace App\Http\Controllers\Pengacara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Office;

class PengacaraController extends Controller
{
    public function showIndex()
    {
        // $referedBy = 'ariefraihandi';
        $title = 'Jasa Pengacara Profesional';
        $subTitle = 'Bilik Hukum';
        $offices = Office::with(['user', 'village', 'regency', 'district', 'province'])->get();
        // dd($offices);
    
        $data = [
            'meta_description' => 'Jasa pengacara profesional di bilikhukum.com. Kami siap membantu Anda dengan berbagai masalah hukum, mulai dari perkara pidana, perdata, hingga bisnis. Konsultasi gratis tersedia.',
            'meta_keywords' => 'pengacara, jasa pengacara, konsultasi pengacara, bantuan hukum, pengacara pidana, pengacara perdata, pengacara bisnis',
            'meta_author' => 'Bilik Hukum',
            'title' => $title,
            'subTitle' => $subTitle,            
            'offices' => $offices,            
        ];

        return view('Pengacara.cariPengacara', compact('data'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search');

            $provinces = Province::where('name', 'like', "%$searchTerm%")->get();
            $regencies = Regency::where('name', 'like', "%$searchTerm%")->get();

            $results = [];
            foreach ($provinces as $province) {
                $results[] = ['value' => $province->code, 'label' => $province->name];
            }
            foreach ($regencies as $regency) {
                $results[] = ['value' => $regency->province_code . '-' . $regency->code, 'label' => $regency->name];
            }

            return response()->json($results);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function searchOffices(Request $request)
    {
        $query = Office::with(['user', 'village', 'regency', 'district', 'province']);
    
        if ($request->has('selectedValue')) {
            $selectedValue = $request->get('selectedValue');
            $values = explode('-', $selectedValue);
            if (count($values) == 2) {
                $query->where('kabupaten_kota', $values[1]);
            } elseif (count($values) == 1) {
                $query->where('provinsi', $values[0]);
            }
        }
    
        $offices = $query->inRandomOrder()->get();
    
        return response()->json($offices);
    }
    
    
}
