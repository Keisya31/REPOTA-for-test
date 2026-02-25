<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class KelolaSkripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-tambah-skripsi');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // proses validasi input
        Log::info('Mulai proses validasi');
        try{
            $request->validate([
                'nama_mhs' => 'required|string|max:70',
                'nim' => [
                    'required',
                    'string',
                    'size:14',
                    Rule::unique('skripsi', 'nim')->whereNull('deleted_at'), // Hanya cek yang belum dihapus
                    'exists:mahasiswa,nim'
                ],
                'judul' => ['required', 
                        function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 30) {
                        $fail('Judul maksimal adalah 30 kata.');
                    }
                    },
                    ],
                'abstrak' => ['required', function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 300) {
                                $fail('Abstrak tidak boleh lebih dari 300 kata.');
                            }
                        },
                        ],
                'tema' => 'nullable|in:siscer,rpl,si,kv',
                'pembimbing_1' => 'required|string|max:70',
                'pembimbing_2' => 'required|string|max:70',
                'penguji' => 'nullable|string|max:70',
                'tanggal_sidang' => 'nullable|date',
                'file_skripsi' => 'nullable|file|mimes:pdf|max:2048',
                'file_depan' => 'nullable|file|mimes:pdf|max:1024',
                'file_bab1' => 'nullable|file|mimes:pdf|max:1024',
            ],
            [
                'nim.exists' => 'NIM tidak terdaftar pada data mahasiswa.',
                'nim.unique'=> 'Skripsi dengan NIM tersebut sudah ada.',
                'file_skripsi.mimes' => 'File harus berformat PDF.',
            ]);
            Log::info('Validasi berhasil');
        }
        catch(\Illuminate\Validation\ValidationException $e){
            Log::error('Validasi gagal:', ['errors' => $e->errors()]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambahkan skripsi, silahkan coba lagi. ' . $e->getMessage()]);
        }

        // proses penyimpanan data
        Log::info('Mulai proses penyimpanan data');
        try{
            // Cari data skripsi berdasarkan NIM, termasuk yang di dalam trash
            $skripsi = Skripsi::withTrashed()->where('nim', $request->nim)->first();

            if ($skripsi) {
                if ($skripsi->trashed()) {
                    Log::info('Data ditemukan di trash, melakukan restore: NIM ' . $request->nim);
                    $skripsi->restore(); // Kembalikan data dari trash
                }
                // Jika data ada tapi tidak di trash, validasi Rule::unique di atas sudah menjaganya agar tidak lolos ke sini
            } else {
                Log::info('Data baru, membuat instance baru');
                $skripsi = new Skripsi();
            }
            
            $skripsi->nim = $request->nim;
            $skripsi->nim_mhs = $request->nim;
            $skripsi->nama_mhs = $request->nama_mhs;
            $skripsi->judul = $request->judul;
            $skripsi->abstrak = $request->abstrak;
            $skripsi->tema = $request->tema;
            $skripsi->pembimbing_1 = $request->pembimbing_1;
            $skripsi->pembimbing_2 = $request->pembimbing_2;
            $skripsi->penguji_sidang = $request->penguji;
            $skripsi->tanggal_sidang = $request->tanggal_sidang;
            if ($request->hasFile('file_skripsi') && $request->file('file_skripsi')->isValid()) {
                $file = $request->file('file_skripsi');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_file = $path;

                Log::info('File uploaded: ' . $filename);
            }
            if ($request->hasFile('file_depan') && $request->file('file_depan')->isValid()) {
                $file = $request->file('file_depan');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_hlm_depan = $path;

                Log::info('File uploaded: ' . $filename);
            }
            if ($request->hasFile('file_bab1') && $request->file('file_bab1')->isValid()) {
                $file = $request->file('file_bab1');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_bab1 = $path;

                Log::info('File uploaded: ' . $filename);
            }
               
            $skripsi->save();
            Log::info('Skripsi berhasil ditambahkan: NIM '.$request->nim);
            session()->flash('success', 'Skripsi Berhasil Ditambahkan!');
            return redirect()->route('admin.dashboard');
            
        }
        catch(\Exception $e){
            Log::error('Gagal menambahkan skripsi: '.$e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error'=> 'Terjadi kesalahan saat menambahkan skripsi. Silahkan coba lagi. ' . $e->getMessage()]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $skripsi = Skripsi::find($id);
        return view('admin.admin-detail-skripsi', compact('skripsi')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $skripsi = Skripsi::find($id);
        return view('admin.admin-edit-skripsi', compact('skripsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        try{
            Log::info("Mulai validasi update skripsi");
            $request->validate([
                'nama_mhs' => 'required|string|max:70',
                'nim' => ['required','string','size:14', Rule::unique('skripsi')->ignore($id)],
                'judul' => ['required', 
                        function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 30) {
                        $fail('Judul maksimal adalah 30 kata.');
                    }
                    },
                    ],
                'abstrak' => ['required', function ($attribute, $value, $fail) {
                            if (str_word_count($value) > 300) {
                                $fail('Abstrak tidak boleh lebih dari 300 kata.');
                            }
                        },
                        ],
                'tema' => 'nullable|in:siscer,rpl,si,kv',
                'pembimbing_1' => 'required|string|max:70',
                'pembimbing_2' => 'required|string|max:70',
                'penguji' => 'nullable|string|max:70',
                'tanggal_sidang' => 'nullable|date',
                'file_skripsi' => 'nullable|file|mimes:pdf|max:2048',
                'file_depan' => 'nullable|file|mimes:pdf|max:1024',
                'file_bab1' => 'nullable|file|mimes:pdf|max:1024',
            ]);
            Log::info('Validasi update berhasil');
        }
        catch(\Illuminate\Validation\ValidationException $e){
            Log::error('Validasi edit skripsi gagal:', ['errors' => $e->errors()]);
            Log::info('Request files:', [
                'has_file' => $request->hasFile('file_skripsi'),
                'is_valid' => $request->file('file_skripsi') ? $request->file('file_skripsi')->isValid() : 'null',
                'error' => $request->file('file_skripsi') ? $request->file('file_skripsi')->getError() : 'null',
            ]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal edit skripsi, silahkan coba lagi. ' . $e->getMessage()]);
        }

        Log::info('Mulai proses edit skripsi');

        try{
            $skripsi = Skripsi::findOrFail($id);
            $skripsi->nim = $request->nim;
            $skripsi->nim_mhs = $request->nim;
            $skripsi->nama_mhs = $request->nama_mhs;
            $skripsi->judul = $request->judul;
            $skripsi->abstrak = $request->abstrak;
            $skripsi->tema = $request->tema;
            $skripsi->pembimbing_1 = $request->pembimbing_1;
            $skripsi->pembimbing_2 = $request->pembimbing_2;
            $skripsi->penguji_sidang = $request->penguji;
            $skripsi->tanggal_sidang = $request->tanggal_sidang;
            if ($request->hasFile('file_skripsi') && $request->file('file_skripsi')->isValid()) {
                $file = $request->file('file_skripsi');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_file = $path;
                Log::info('File uploaded: ' . $filename);
            }
            if ($request->hasFile('file_depan') && $request->file('file_depan')->isValid()) {
                $file = $request->file('file_depan');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_hlm_depan = $path;
                Log::info('File uploaded: ' . $filename);
            }
            if ($request->hasFile('file_bab1') && $request->file('file_bab1')->isValid()) {
                $file = $request->file('file_bab1');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('skripsi', $filename, 'public');
                $skripsi->path_bab1 = $path;
                Log::info('File uploaded: ' . $filename);
            }

            $skripsi->save();
            Log::info('Skripsi berhasil diupdate: NIM '.$request->nim);
            session()->flash('success', 'Skripsi Berhasil Diupdate!');
            return redirect()->route('admin.dashboard');

        }
        catch(\Exception $e){
            Log::error('Gagal mengedit skripsi: '.$e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error'=> 'Terjadi kesalahan saat mengedit skripsi. Silahkan coba lagi. ' . $e->getMessage()]);
            
        }
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info("fungsi destroy data skripsi");
        try{
            $skripsi = Skripsi::findOrFail($id);
            $skripsi->delete();
            Log::info('Berhasil hapus data skripsi terkait.');
            session()->flash('success', 'Skripsi Berhasil Dihapus!');
            return redirect()->route('admin.dashboard');
        }catch (\Exception $e) {
            Log::error('Gagal menghapus data skripsi: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error'=> 'Terjadi kesalahan saat menghapus skripsi.' . $e->getMessage()]);
        }
    
    }

    // Download file skripsi.
    
    public function download($id)
    {
        try {
            $skripsi = Skripsi::findOrFail($id);
            $path = $skripsi->path_file;
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

    public function downloadHlmDepan($id)
    {
        try {
            $skripsi = Skripsi::findOrFail($id);
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
            $skripsi = Skripsi::findOrFail($id);
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
}
