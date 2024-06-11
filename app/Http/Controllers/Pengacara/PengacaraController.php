<?php

namespace App\Http\Controllers\Pengacara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Office;
use App\Models\OfficeCase;

class PengacaraController extends Controller
{
    public function showIndex()
    {
        $title = 'Jasa Pengacara Profesional';
        $subTitle = 'Bilik Hukum';
        $offices = Office::with(['user', 'village', 'regency', 'district', 'province'])->get();

        // Add average fee and label count to each office
        foreach ($offices as $office) {
            $officeCases = OfficeCase::where('office_id', $office->id)->with('legalCase')->get();
            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });
            $office->average_fee = $averageFee;
            $office->label_count = $this->determineLabel($averageFee);
        }

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

    public function getNameByCode($code)
    {
        if (strpos($code, '.') !== false) {
            // Kode kabupaten
            $regency = Regency::where('code', $code)->first();
            if ($regency) {
                $formattedName = $this->formatName($regency->name);
                return response()->json(['name' => $formattedName]);
            }
            return response()->json(['error' => 'Regency not found'], 404);
        } else {
            // Kode provinsi
            $province = Province::where('code', $code)->first();
            if ($province) {
                $formattedName = $this->formatName($province->name);
                return response()->json(['name' => $formattedName]);
            }
            return response()->json(['error' => 'Province not found'], 404);
        }
    }

    private function formatName($name)
    {
        $lowercasedName = strtolower($name); // Mengubah semua huruf menjadi kecil
        $formattedName = ucwords($lowercasedName); // Mengubah huruf pertama setiap kata menjadi besar
        return $formattedName;
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
        
        $offices = $query->get();
    
        foreach ($offices as $office) {
            $officeCases = OfficeCase::where('office_id', $office->id)->with('legalCase')->get();
            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });
            $office->average_fee = $averageFee;
            $office->label_count = $this->determineLabel($averageFee);
        }
        
        return response()->json($offices);
    }
    
    
    private function determineLabel($averageFee)
    {
        if ($averageFee <= 15000000) {
            return 1; // $
        } elseif ($averageFee <= 30000000) {
            return 2; // $$
        } elseif ($averageFee <= 60000000) {
            return 3; // $$$
        } elseif ($averageFee <= 120000000) {
            return 4; // $$$$
        } else {
            return 5; // $$$$$
        }
    }

}
