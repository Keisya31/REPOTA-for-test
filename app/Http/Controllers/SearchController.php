<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IrService;
use App\Models\Skripsi; 

class SearchController extends Controller
{
    public function index(Request $request, IrService $irService)
    {
        $query = $request->input('search');
        $results = collect();

        if ($query) {
            // 1. Ambil Data dari Database
            // Ambil kolom id, judul, abstrak dan nim (dibutuhkan untuk relasi)
            // Eager-load Mahasiswa tapi batasi kolom yang diambil (nim, mhs_nama)
            $skripsis = Skripsi::withTrashed()
                ->select('id', 'judul', 'abstrak', 'tema', 'nim_mhs', 'nama_mhs')
                ->get();

            // 2. Siapkan variabel wadah penampung
            $docsTokens = [];
            $docMap = [];

            // 3. Preprocessing Semua Dokumen (Looping)
            foreach ($skripsis as $skripsi) {
                // Gabung Judul + Abstrak + atribut Mahasiswa (nama + nim) sebagai teks yang dicari
                $mahasiswaName = $skripsi->nama_mhs ?? '';
                $mahasiswaNim = $skripsi->nim_mhs ?? '';
                $content = trim($skripsi->judul . ' ' . $skripsi->abstrak . ' '.$skripsi->tema . ' ' . $mahasiswaName . ' ' . $mahasiswaNim);
                // cek data
                // dd($content);
                // Panggil fungsi Preprocessing dari Service
                $tokens = $irService->preprocessing($content);
                
                $docsTokens[$skripsi->id] = $tokens;
                $docMap[$skripsi->id] = $skripsi;
                
            }

            // 4. Preprocessing Query User
            $queryTokens = $irService->preprocessing($query);

            // 5. Hitung IDF Global
            $idf = $irService->computeIDF($docsTokens);

            // 6. Hitung Similarity per Dokumen
            $scores = [];
            foreach ($docsTokens as $id => $tokens) {
                $score = $irService->computeCosineSimilarity($queryTokens, $tokens, $idf);
                
                // Ambil yang skornya di atas 0 (Ada kemiripan)
                if ($score > 0) {
                    $scores[$id] = $score;
                }
            }

            // 7. Ranking (Urutkan dari skor tertinggi)
            arsort($scores);

            // 8. Susun hasil untuk dikirim ke View
            $resultsArray = [];
            foreach ($scores as $id => $score) {
                $skripsi = $docMap[$id];
                $skripsi->score = $score; // Tempel nilai skor
                $resultsArray[] = $skripsi;
            }
            // dd($resultsArray);
            $results = collect($resultsArray);
        }

        return view('base', compact('results', 'query'));
    }
}