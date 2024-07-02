<?php

namespace App\Http\Controllers\Pengacara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\OfficeGallery;
use App\Models\Office;
use App\Models\OfficeCase;
use App\Models\OfficeSite;
use App\Models\OfficeMember;
use App\Models\KlienChat;
use Illuminate\Support\Facades\Session;

class PengacaraController extends Controller
{
    public function showLandingPage($website)
    {
        $referralToken = Session::get('referral_token', null);
        $office = Office::where('website', $website)->with(['village', 'district', 'regency', 'province'])->first();

        // Check if the office exists
        if ($office) {
            // Query the OfficeSite model using the office_id
            $officeSite = OfficeSite::where('office_id', $office->id)->first();

            // Check if officeSite exists
            if ($officeSite) {
                $establishedDate    = new \DateTime($office->tanggal_pendirian);
                $currentDate        = new \DateTime();
                $interval           = $currentDate->diff($establishedDate);
                $yearsOfExperience  = $interval->y;
                $klienChatCount     = KlienChat::where('id_office', $office->id)->count();
                $legalCases         = $office->legalCases()->get();
                $services           = $legalCases->random(min($legalCases->count(), 20));
                $officeMembers      = OfficeMember::where('id_office', $office->id)->with('user')->get();

                // Filter unique categories and select random case for each
                $uniqueCategories = $legalCases->unique('kategori')->take(8);
                $legalCasesRandomized = $uniqueCategories->map(function ($category) use ($legalCases) {
                    $casesInCategory = $legalCases->where('kategori', $category->kategori);
                    return $casesInCategory->random();
                });

                $officeGalleries = OfficeGallery::where('office_id', $office->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            
                $data = [
                    'nama_kantor' => $office->nama_kantor,
                    'id' => $office->id,
                    'referralToken' => $referralToken,
                    'type' => $office->type,
                    'alamat' => $office->alamat,
                    'slogan' => $office->slogan,
                    'website' => $website,
                    'logo' => $office->logo,                   
                    'yearsOfExperience' => $yearsOfExperience,
                    'klien_chat_count' => $klienChatCount,
                    'legalCasesRandomized' => $legalCasesRandomized,
                    'services' => $services,
                    'officeGalleries' => $officeGalleries, 
                    'officeMembers' => $officeMembers, 
                    'alamat' => $this->capitalizeWords($office->alamat),
                    'kode_pos' => $office->kode_pos,
                    'desa' => $this->capitalizeWords($office->village->name),
                    'kecamatan' => $this->capitalizeWords($office->district->name),
                    'kabupaten_kota' => $this->capitalizeWords($office->regency->name),
                    'provinsi' => $this->capitalizeWords($office->province->name),
                    // OfficeSite fields
                    // 'office_name' => $officeSite->office_name,
                    // 'logo_image' => $officeSite->logo_image,
                    'owner_image'           => $officeSite->owner_image,
                    'owner_sec_image'       => $officeSite->owner_sec_image,
                    'icon_image'            => $officeSite->icon_image,
                    'logo_image'            => $officeSite->logo_image,
                    'tagline'               => $officeSite->tagline,
                    'aboutMe_title'         => $officeSite->aboutMe_title,
                    'aboutMe_description'   => $officeSite->aboutMe_description,
                    // 'aboutMe_legalcategory' => $officeSite->aboutMe_legalcategory,
                ];
                
                return view('Pengacara.landingPage.index', $data);
            } else {
                return response()->json(['error' => 'Office not found'], 404);
            }
        }
    }

    private function capitalizeWords($string) {
        return ucwords(strtolower($string));
    }

    public function showIndex()
    {
      
        $referralToken = Session::get('referral_token', null);

        $title      = 'Jasa Pengacara Profesional';
        $subTitle   = 'Bilik Hukum';
        $offices    = Office::with(['user', 'village', 'regency', 'district', 'province'])
                    ->where('status', 2)
                    ->get();

        foreach ($offices as $office) {
            $officeCases = OfficeCase::where('office_id', $office->id)->with('legalCase')->get();
            $averageFee = $officeCases->avg(function ($officeCase) {
                return ($officeCase->min_fee + $officeCase->max_fee) / 2;
            });
            $office->average_fee = $averageFee;
            $office->label_count = $this->determineLabel($averageFee);

            // Get unique legal cases
            $legalCases = $officeCases->map(function ($officeCase) {
                return $officeCase->legalCase;
            })->unique('id');

            // Choose a random legal case
            if ($legalCases->isNotEmpty()) {
                $office->random_legal_case = $legalCases->random();
                $office->other_cases_count = $legalCases->count() - 1;
            } else {
                $office->random_legal_case = null;
                $office->other_cases_count = 0;
            }
        }

        // Shuffle the collection
        $offices = $offices->shuffle();

        $data = [
            'meta_description' => 'Jasa pengacara profesional di bilikhukum.com. Kami siap membantu Anda dengan berbagai masalah hukum, mulai dari perkara pidana, perdata, hingga bisnis. Konsultasi gratis tersedia.',
            'meta_keywords' => 'pengacara, jasa pengacara, konsultasi pengacara, bantuan hukum, pengacara pidana, pengacara perdata, pengacara bisnis',
            'meta_author' => 'Bilik Hukum',
            'title' => $title,
            'subTitle' => $subTitle,
            'offices' => $offices,
            'referralToken' => $referralToken,
        ];

        return view('Pengacara.cariPengacara', compact('data'));
    }

    public function getNameByCode($code)
    {
        if (strpos($code, '-') !== false) {
            // Pisahkan kode berdasarkan tanda -
            $parts = explode('-', $code);
            $regencyCode = $parts[1]; // Ambil bagian setelah tanda -
            
            // Kode kabupaten
            $regency = Regency::where('code', $regencyCode)->first();
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
        $query = Office::with(['user', 'village', 'regency', 'district', 'province'])
                       ->where('status', 2);
    
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
    
            $legalCases = $officeCases->map(function ($officeCase) {
                return $officeCase->legalCase;
            })->unique('id');
    
            if ($legalCases->isNotEmpty()) {
                $office->random_legal_case = $legalCases->random();
                $office->other_cases_count = $legalCases->count() - 1;
            } else {
                $office->random_legal_case = null;
                $office->other_cases_count = 0;
            }
        }
    
        return response()->json($offices);
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

}
