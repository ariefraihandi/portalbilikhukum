<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuleAType;
use App\Models\RuleBUndang;
use App\Models\RuleCaBagian;
use App\Models\RuleCBab;
use App\Models\RuleDPasal;
use App\Models\RuleEAyat;
use App\Models\RuleFHuruf;
use App\Models\RuleGAngka;
use Illuminate\Support\Facades\DB;
use Exception;
use DataTables;

class JdihController extends Controller
{

    protected $typeMapping = [
        'uu' => 'UU_PERPU',
        'perpu' => 'UU_PERPU',
        'pp' => 'PP',
        'perpres' => 'PERPRES',
        'perda_prov' => 'PERDA_PROV',
        'perda_kab_kota' => 'PERDA_KAB_KOTA'
    ];

    public function showIndex()
    {
        $title = 'Kamus Undang-Undang';
        $subTitle = 'Cari Undang-Undang dan Pasal';

        // Fetch all laws initially or you can modify this to show most recent or most popular laws
        $laws = RuleBUndang::with(['babs.pasals.ayats'])->get();

        $data = [
            'meta_description' => 'Cari undang-undang dan pasal di bilikhukum.com. Kami menyediakan database lengkap UUD dan pasal-pasal terkait.',
            'meta_keywords' => 'undang-undang, pasal, hukum, peraturan, bilik hukum',
            'meta_author' => 'Bilik Hukum',
            'title' => $title,
            'subTitle' => $subTitle,
            'laws' => $laws,
        ];

        return view('Pengacara.lawDictinory', compact('data'));
    }

    public function showLaw($type = null, $number = null, $year = null, $pasal = null)
    {
        // If type is provided, fetch the corresponding id from rule_a_types
        if ($type) {
            $dbType = $this->typeMapping[strtolower($type)] ?? null;
            if ($dbType) {
                $typeRecord = RuleAType::where('type', $dbType)->first();
                if ($typeRecord) {
                    // Get the id from the typeRecord
                    $typeId = $typeRecord->id;
    
                    // Fetch the corresponding records from rule_b_undang
                    $lawsQuery = RuleBUndang::where('type_id', $typeId);
    
                    // If number is provided, add it to the query
                    if ($number) {
                        $lawsQuery->where('nomor', $number);
                    }
    
                    // If year is provided, add it to the query
                    if ($year) {
                        $lawsQuery->where('tahun', $year);
                    }
    
                    // Get the laws and related data
                    $laws = $lawsQuery->with(['babs.pasals.ayats.hurufs.angkas'])->get();
    
                    // Fetch pasal details from specific law
                    $pasalDetails = null;
                    if ($pasal && $number && $year) {
                        $law = RuleBUndang::where('nomor', $number)
                            ->where('tahun', $year)
                            ->first();
    
                        if ($law) {
                            $pasalDetails = RuleDPasal::where('pasal_ke', $pasal)
                                ->whereHas('bab', function ($query) use ($law) {
                                    $query->where('rule_b_undang_id', $law->id);
                                })
                                ->with(['ayats.hurufs.angkas', 'bab', 'bagian'])
                                ->paginate(1);
                        }
                    }
    
                    // Prepare meta description and keywords based on the laws
                    $metaDescription = 'Daftar peraturan di bilikhukum.com. ';
                    $metaKeywords = 'undang-undang, pasal, hukum, peraturan, bilik hukum, ';
                    foreach ($laws as $law) {
                        $metaDescription .= $law->name . ' ' . $law->nomor . ' ' . $law->tahun . ', ';
                        $metaKeywords .= $law->name . ', ' . $law->tentang . ', ';
                    }
    
                    // Prepare data for the view
                    $data = [
                        'meta_description' => rtrim($metaDescription, ', '),
                        'meta_keywords' => rtrim($metaKeywords, ', '),
                        'meta_author' => 'Bilik Hukum',
                        'title' => 'Daftar Peraturan',
                        'subTitle' => $laws->first()->name ?? 'Daftar Peraturan',
                        'laws' => $laws,
                        'pasalDetails' => $pasalDetails,
                    ];
    
                    return view('Pengacara.lawDictinory', compact('data'));
                } else {
                    return redirect()->route('showDictionary')->with('error', 'Type not found');
                }
            } else {
                return redirect()->route('showDictionary')->with('error', 'Invalid type provided');
            }
        }
    
        // If type, number, year, and pasal are not provided, show the initial data
        if (is_null($type) && is_null($number) && is_null($year) && is_null($pasal)) {
            return $this->showIndex();
        }
    }
    

    public function showUUList(Request $request)
    {
        // Ambil semua data RuleAType
        $ruleATypes = RuleAType::all();

        $data = [
            'title'             => 'JDIH List',
            'subtitle'          => 'Bilik Hukum',
            'sidebar'           => $request->get('accessMenus'),
            'ruleATypes'        => $ruleATypes, // Kirim data RuleAType ke view
        ];

        return view('Portal.JDIH.uu', $data);
    }

    public function storeRule(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'type_id' => 'required|exists:rule_a_types,id',
                'name' => 'required|string|max:255',
                'nomor' => 'required|string|max:255',
                'tahun' => 'required|integer',
                'tentang' => 'required|string|max:255',
                'materi_pokok' => 'required',
                'menimbang' => 'required',
                'mengingat' => 'required',
                'mencabut' => 'required',
                'menetapkan' => 'required',
                'persetujuan' => 'required',
                'bab' => 'nullable|boolean',
                'tanggal_penetapan' => 'required|date',
                'tanggal_pengundangan' => 'required|date',
                'tanggal_berlaku' => 'required|date',
                'sumber' => 'required|string|max:255',
            ]);

            // Convert arrays to strings
            // $validatedData['menimbang'] = implode('|', $validatedData['menimbang']);
            // $validatedData['mengingat'] = implode('|', $validatedData['mengingat']);
            // $validatedData['menetapkan'] = implode('|', $validatedData['menetapkan']);
            // $validatedData['mencabut'] = implode('|', $validatedData['mencabut']);

            RuleBUndang::create($validatedData);

            // Jika berhasil, redirect dengan sweet alert success
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Aturan Ditambahkan',
                ],
            ]);
        } catch (Exception $e) {
            // Jika terjadi kesalahan, redirect dengan sweet alert error
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function storePasal(Request $request)
{
    DB::beginTransaction();

    try {
        // Check if ayat_content is an array
        if (!is_array($request->ayat_content)) {
            throw new \Exception('ayat_content must be an array.');
        }

        // Determine if there are any ayat_contents
        $hasAyat = false;
        foreach ($request->ayat_content as $ayatContents) {
            if (!empty($ayatContents[0])) {
                $hasAyat = true;
                break;
            }
        }

        if ($hasAyat) {
            // Create Pasal with content
            $pasal = RuleDPasal::create([
                'rule_c_bab_id' => $request->rule_c_bab_id,
                'pasal_ke' => $request->pasal_number,
                'rule_ca_bagian_id' => $request->rule_ca_bagian_id,
                'pasal_content' => $request->pasal_content
            ]);

            foreach ($request->ayat_content as $ayatKey => $ayatContents) {
                if (!is_array($ayatContents)) {
                    continue; // Skip if ayatContents is not an array
                }

                foreach ($ayatContents as $ayatContent) {
                    if (!is_null($ayatContent)) {
                        // Create Ayat
                        $ayat = RuleEAyat::create([
                            'rule_d_pasal_id' => $pasal->id,
                            'ayat_content' => $ayatContent
                        ]);

                        if (isset($request->huruf_content[$ayatKey]) && is_array($request->huruf_content[$ayatKey])) {
                            foreach ($request->huruf_content[$ayatKey] as $hurufKey => $hurufContent) {
                                if (!is_null($hurufContent)) {
                                    // Create Huruf
                                    $huruf = RuleFHuruf::create([
                                        'rule_e_ayat_id' => $ayat->id,
                                        'huruf_content' => $hurufContent
                                    ]);

                                    // Log huruf creation for debugging
                                    \Log::info('Created Huruf: ', ['huruf' => $huruf]);

                                    if (isset($request->angka_content[$ayatKey][$hurufKey]) && is_array($request->angka_content[$ayatKey][$hurufKey])) {
                                        foreach ($request->angka_content[$ayatKey][$hurufKey] as $angkaContent) {
                                            if (!is_null($angkaContent)) {
                                                // Create Angka
                                                $angka = RuleGAngka::create([
                                                    'rule_f_huruf_id' => $huruf->id,
                                                    'angka_content' => $angkaContent
                                                ]);

                                                // Log angka creation for debugging
                                                \Log::info('Created Angka: ', ['angka' => $angka]);
                                            }
                                        }
                                    } else {
                                        // Log if no angka_content is found
                                        \Log::info('No angka_content found for huruf', ['huruf_id' => $huruf->id]);
                                    }
                                }
                            }
                        } else {
                            // Log if no huruf_content is found
                            \Log::info('No huruf_content found for ayat', ['ayat_id' => $ayat->id]);
                        }
                    }
                }
            }
        } else {
            // If 'Memiliki Ayat' is not checked, save only the pasal_content directly
            $pasal = RuleDPasal::create([
                'rule_c_bab_id' => $request->rule_c_bab_id,
                'rule_ca_bagian_id' => $request->rule_ca_bagian_id,
                'pasal_ke' => $request->pasal_number,
                'pasal_content' => $request->pasal_content
            ]);
        }

        DB::commit();
        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Data has been saved successfully',
            ],
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        // Log the error for debugging purposes
        \Log::error('Error in storePasal: ', ['error' => $e->getMessage()]);
        return redirect()->back()->with([
            'response' => [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Error: ' . $e->getMessage(),
            ],
        ]);
    }
}

    
    public function getRuleData(Request $request)
    {
        if ($request->ajax()) {
            $data = RuleBUndang::select([
                    'id', // Ensure to include 'id' for DataTables to handle row actions
                    'type_id',
                    'name',
                    'nomor',
                    'tahun',
                    'tentang',
                    'bab',
                    'tanggal_penetapan',
                    'tanggal_pengundangan',
                    'tanggal_berlaku',
                ])
                ->get();

            return DataTables::of($data)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('type_id', function ($data) {
                $ruleAType = RuleAType::find($data->type_id);
                return $ruleAType ? $ruleAType->type : '';
            })
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('nomor', function ($data) {
                return $data->nomor;
            })
            ->addColumn('tahun', function ($data) {
                return $data->tahun;
            })
            ->addColumn('tentang', function ($data) {
                return $data->tentang;
            })
            ->addColumn('bab', function ($data) {
                $count = RuleCBab::where('rule_b_undang_id', $data->id)->count();
                return $count > 0 ? $count . ' bab' : '0 bab';
            })
            
            ->addColumn('tanggal_penetapan', function ($data) {
                return $data->tanggal_penetapan->format('Y-m-d');
            })
            ->addColumn('tanggal_pengundangan', function ($data) {
                return $data->tanggal_pengundangan->format('Y-m-d');
            })
            ->addColumn('tanggal_berlaku', function ($data) {
                return $data->tanggal_berlaku->format('Y-m-d');
            })
            ->addColumn('actions', function ($data) {
                $addBagianButton = '<a href="#" class="btn btn-sm btn-info add-bagian-button" data-bs-toggle="modal" data-bs-target="#addBagianModal" data-id="' . $data->id . '">' .
                '<i class="fas fa-plus"></i>' .
            '</a>';
            
                $addBabButton = '<a href="#" class="btn btn-sm btn-success add-bab-button" data-bs-toggle="modal" data-bs-target="#addBabModal" data-id="' . $data->id . '">' .
                                        '<i class="fas fa-plus"></i>' .
                                    '</a>';
            
                $addPasalButton = '<a href="#" class="btn btn-sm btn-primary add-pasal-button" data-bs-toggle="modal" data-bs-target="#addPasalModal" data-id="' . $data->id . '">' .
                                        '<i class="fas fa-plus"></i>' .
                                    '</a>';
            
                return $addBabButton . ' ' . $addBagianButton . ' ' . $addPasalButton;
            })
            
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('rules.index');
    }

    public function storeBab(Request $request)
    {
        $validatedData = $request->validate([
            'rule_b_undang_id' => 'required|exists:rule_b_undang,id',
            'bab_ke' => 'required|string|max:255',
            'bab_name' => 'required|string|max:255',
        ]);

        try {
            RuleCBab::create($validatedData);

            return redirect()->back()->with([
                'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Bab berhasil ditambahkan!'
            ],
        ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'response' => [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Terjadi kesalahan saat menambahkan bab.'
            ],
        ]);
        }
    }

    public function storebagian(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'rule_b_undang_id' => 'required|integer',
            'id_bab' => 'required|integer',
            'bagian_name' => 'required|string|max:255',
            'bagian_ke' => 'required|string|max:255',
        ]);
    
        // Simpan data ke dalam database
        $bagian = RuleCaBagian::create($validatedData);
    
        // Redirect atau response sesuai kebutuhan aplikasi Anda
        return redirect()->back()->with([
            'response' => [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Bagian berhasil ditambahkan!'
            ]
        ]);
    }
    

    public function getBabs($rule_b_undang_id)
    {
        $babs = RuleCBab::where('rule_b_undang_id', $rule_b_undang_id)->get();
        return response()->json($babs);
    }
    
    public function getBagiansByBabId($babId)
    {
        $babs = RuleCaBagian::where('id_bab', $babId)->get();
        return response()->json($babs);
    }
    
}

