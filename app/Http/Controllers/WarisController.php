<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarisController extends Controller
{
    public function index()
    {
        $title      = 'Hitung Waris';
        $subTitle   = 'Bilik Hukum';

    $data = [
        'meta_description' => 'Layanan hitung waris paling akurat di bilikhukum.com. Kami siap membantu Anda menghitung pembagian waris sesuai dengan hukum yang berlaku. Konsultasi gratis tersedia.',
        'meta_keywords' => 'hitung waris, jasa hitung waris, konsultasi waris, bantuan hukum waris, pembagian waris, hukum waris',
        'meta_author' => 'Bilik Hukum',
            'title' => $title,
            'subTitle' => $subTitle,
        ];

        return view('HitungWaris.app', compact('data'));
    }

    public function calculateWaris(Request $request)
    {
        $totalAsset = $request->input('totalAsset');
        $numSons = $request->input('numSons');
        $numDaughters = $request->input('numDaughters');
        $hasHusband = $request->input('hasHusband');
        $hasWife = $request->input('hasWife');

        $results = $this->calculateInheritance($totalAsset, $numSons, $numDaughters, $hasHusband, $hasWife);

        return view('index', compact('results'));
    }

    private function calculateInheritance($totalAsset, $numSons, $numDaughters, $hasHusband, $hasWife)
    {
        // Menghitung bagian suami/istri
        $spouseShare = 0;
        if ($hasHusband) {
            $spouseShare = $totalAsset * 0.25;
        } elseif ($hasWife) {
            $spouseShare = $totalAsset * 0.125;
        }

        // Menghitung sisa harta setelah bagian suami/istri
        $remainingAsset = $totalAsset - $spouseShare;
        $totalChildren = $numSons + $numDaughters;

        // Menghitung bagian anak laki-laki dan perempuan
        $sonShare = 0;
        $daughterShare = 0;

        if ($totalChildren > 0) {
            $unitShare = $remainingAsset / ($numSons * 2 + $numDaughters);
            $sonShare = $unitShare * 2;
            $daughterShare = $unitShare;
        }

        return [
            'spouse' => $spouseShare,
            'sons' => $numSons > 0 ? $sonShare * $numSons : 0,
            'daughters' => $numDaughters > 0 ? $daughterShare * $numDaughters : 0,
        ];
    }
}
