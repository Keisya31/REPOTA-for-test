<?php

namespace App\Http\Controllers;

use App\Models\Percakapan;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PercakapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Tampilan main forum
    public function index()
    {
        // Main forum thread, nampilin semua percakapan
        $mainThread = Percakapan::whereNull('parent_id')
            ->whereNull('skripsi_id')
            ->with('replies')
            ->latest()
            ->first();
            
        $mainThreadCount = Percakapan::whereNull('skripsi_id')->count();    
        
        // Tampilan thread per forum skripsi
        $skripsiThreads = Percakapan::whereNull('parent_id')
            ->whereNotNull('skripsi_id')
            ->with(['skripsi','replies'])
            ->select('skripsi_id')
            ->selectRaw('MAX(created_at) as latest_message')
            ->selectRaw('COUNT(*) as message_count')
            ->groupBy('skripsi_id')
            ->orderBy('latest_message', 'desc')
            ->get();

        // Tampilan full skripsi dengan semua pesan
        $rooms  = [];
        foreach ($skripsiThreads as $thread){
            $skripsi = Skripsi::withTrashed()->find($thread->skripsi_id);
            if($skripsi){
                $totalMessages = Percakapan::where('skripsi_id', $thread->skripsi_id)->count();
                $lastMessages = Percakapan::where('skripsi_id', $thread->skripsi_id)
                    ->latest()
                    ->first();
                $rooms[] = [
                    'skripsi' => $skripsi,
                    'message_count' =>$totalMessages,
                    'last_message' => $lastMessages,
                ];
            }
        }
        return view('forum.percakapan', compact('mainThread', 'mainThreadCount', 'rooms'));
    }
    
    // Tampilan forum per skripsi
    public function forumSkripsi($id){
        $skripsi = Skripsi::withTrashed()->findOrFail($id);    
        $threads = Percakapan::whereNull('parent_id')->where('skripsi_id', $id)->first();
        // $threads = Percakapan::where('skripsi_id', $id)->first();
        $replies = [];
        if($threads){
            $replies = Percakapan::where('parent_id', $threads->id)->get();
        }
        return view('forum.skripsi', compact('threads', 'skripsi', 'replies'));
    }

    public function show($id)
    {
        // $skripsi = Skripsi::findOrFail($id);
        $thread = Percakapan::findOrFail($id);
        // $thread = Percakapan::whereNull('parent_id')->where('skripsi_id', $id)->latest()->first();
        // $thread = Percakapan::where('parent_id')->get()->first();
        $replies = Percakapan::where('parent_id', $id)->get();

        return view('forum.detail', compact('thread', 'replies'));
    }


    public function mainForum()
    {
        $threads = Percakapan::whereNull('parent_id')
            ->whereNull('skripsi_id')
            ->with('replies')
            ->latest()
            ->get();

        return view('forum.mainForum', compact('threads'));
    }

    /**
     * Menyimpan pesan/thread baru
     */
   public function store(Request $request)
    {
        $user = Auth::user();
        $namaPengirim = 'Anonymous';

        if ($user) {
            if ($user->role === 'adm') {
                $namaPengirim = $user->admin->adm_nama ?? $user->username;
            } elseif ($user->role === 'mhs') {
                $namaPengirim = $user->mahasiswa->mhs_nama ?? $user->username;
            }
        }

        Percakapan::create([
            'isi_pesan' => $request->isi_pesan,
            'parent_id' => null,
            'user_id' => Auth::id(), // Null jika anonim
            'session_token' => session()->getId(), // Tiket unik browser
            'skripsi_id' => $request->skripsi_id,
            'nama_pengirim' => $namaPengirim,
        ]);

        return redirect()->back();
    }
    
    // Untuk menambahkan reply
    public function reply(Request $request)
    {
         $user = Auth::user();
        $namaPengirim = 'Anonymous';

        if ($user) {
            if ($user->role === 'adm') {
                $namaPengirim = $user->admin->adm_nama ?? $user->username;
            } elseif ($user->role === 'mhs') {
                $namaPengirim = $user->mahasiswa->mhs_nama ?? $user->username;
            }
        }

        Percakapan::create([
            'isi_pesan' => $request->isi_pesan,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
            'session_token' => session()->getId(),
            'skripsi_id' => $request->skripsi_id,
            'nama_pengirim' => $namaPengirim,
        ]);

        return back();
    }

   public function update(Request $request, $id)
    {
        $percakapan = Percakapan::findOrFail($id);
        $currentSession = session()->getId();

        // Logika kepemilikan: Cek ID User (jika login) ATAU Cek Session Token (jika anonim)
        $isOwner = (Auth::check() && $percakapan->user_id === Auth::id()) || 
                (!$percakapan->user_id && $percakapan->session_token === $currentSession);

        if (!$isOwner) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit pesan ini.');
        }

        $percakapan->update([
            'isi_pesan' => $request->isi_pesan
        ]);

        return back()->with('success', 'Pesan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $percakapan = Percakapan::findOrFail($id);
        $currentSession = session()->getId();

        // Admin bisa hapus semua
        $isAdmin = Auth::check() && Auth::user()->role === 'adm';
        
        // Pemilik (Mahasiswa/Anonim) bisa hapus pesan sendiri
        $isOwner = (Auth::check() && $percakapan->user_id === Auth::id()) || 
                (!$percakapan->user_id && $percakapan->session_token === $currentSession);

        if ($isAdmin || $isOwner) {
            $percakapan->delete();
            return back()->with('success', 'Pesan berhasil dihapus');
        }

        return back()->with('error', 'Tidak diizinkan menghapus pesan ini.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Percakapan $percakapan)
    {
        //
    }

}
