<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class KelolaMahasiswaController extends Controller
{
    public function index(Request $request){
        // Ambil input pencarian dari form
        $search = $request->input('search');

        // Query data mahasiswa
        $mahasiswa = Mahasiswa::query()
        ->when($search, function ($query, $search) {
            return $query->where('mhs_nama', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('semester', 'like', "%{$search}%");
        })
        ->latest() 
        ->paginate(15); 

        return view('admin.admin-kelola-mahasiswa', compact('mahasiswa'));
    }

    public function import(Request $request)
    {
        // 1. Validasi file
        Log::info("Mulai validasi file import mahasiswa");
        $request->validate([
            'file_mahasiswa' => 'required|mimes:xlsx,xls,csv|max:5048',
        ]);
        Log::info("file import mahasiswa berhasil divalidasi");

        try {
            // 2. Proses Import
            Log::info("Mulai import file mahasiswa");
            $file = $request->file('file_mahasiswa');
            
            Excel::import(new MahasiswaImport, $file);
            Log::info("proses import mahasiswa berhasil selesai");
            session()->flash('success', 'Daftar Mahasiswa Berhasil Ditambahkan!');
            return redirect()->route('admin.kelola-mahasiswa');
                            
        } catch (\Exception $e) {
            // Jika format excel salah atau ada NIM duplikat
            Log::info("gagal import file mahasiswa: " . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error'=> 'Terjadi kesalahan saat menambahkan mahasiswa. Silahkan coba lagi. ' . $e->getMessage()]);
        }
    }

    public function destroy($nim)
    {
        Log::info("fungsi destroy data mahasiswa");
        try{
            $mahasiswa = Mahasiswa::findOrFail($nim);
            $mahasiswa->delete();
            Log::info('Berhasil hapus data mahasiswa terkait.');
            session()->flash('success', 'Mahasiswa Berhasil Dihapus!');
            return redirect()->route('admin.kelola-mahasiswa');
        }catch (\Exception $e) {
            Log::error('Gagal menghapus data mahasiswa: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error'=> 'Terjadi kesalahan saat menghapus mahasiswa.' . $e->getMessage()]);
        }
    
    }

    public function destroyAll()
    {
        // Menggunakan Soft Delete agar data aman (bisa direstore)
        Mahasiswa::query()->delete(); 

        return redirect()->back()->with('success', 'Seluruh data mahasiswa berhasil dikosongkan.');
    }
}
