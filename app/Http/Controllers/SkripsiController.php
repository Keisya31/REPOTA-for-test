<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $skripsi=Skripsi::withTrashed()->find($id);
        return view('detail-skripsi', compact('skripsi'));
    }

    // Download file skripsi.
    
    
     public function downloadHlmDepan($id)
    {
        try {
            $skripsi = Skripsi::withTrashed()->findOrFail($id);
            $path = $skripsi->path_hlm_depan;
            if (!$path) {
                return redirect()->back()->withErrors(['error' => 'File tidak ditemukan.']);
            }

            if (Storage::disk('public')->exists($path)) {
                return response()->download(storage_path('app/public/' . $path), basename($path));
            }

            return redirect()->back()->withErrors(['error' => 'File tidak ditemukan di penyimpanan.']);
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh file skripsi: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengunduh file.']);
        }
    }

    public function downloadBab1($id)
    {
        try {
            $skripsi = Skripsi::withTrashed()->findOrFail($id);
            $path = $skripsi->path_bab1;
            if (!$path) {
                return redirect()->back()->withErrors(['error' => 'File tidak ditemukan.']);
            }

            if (Storage::disk('public')->exists($path)) {
                return response()->download(storage_path('app/public/' . $path), basename($path));
            }

            return redirect()->back()->withErrors(['error' => 'File tidak ditemukan di penyimpanan.']);
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh file skripsi: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mengunduh file.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Skripsi $skripsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skripsi $skripsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skripsi $skripsi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skripsi $skripsi)
    {
        //
    }
}
