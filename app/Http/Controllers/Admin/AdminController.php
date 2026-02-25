<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $skripsi = Skripsi::with(['mahasiswa']) // Eager loading 
            ->when($search, function ($query, $search) {
                // Gunakan where() 
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('abstrak', 'like', "%{$search}%")
                    ->orWhere('pembimbing_1', 'like', "%{$search}%")
                    ->orWhere('pembimbing_2', 'like', "%{$search}%")
                    ->orWhere('penguji_sidang', 'like', "%{$search}%")
                    
                    // Pencarian ke tabel mahasiswa
                    ->orWhereHas('mahasiswa', function($q_mhs) use ($search) {
                        $q_mhs->where('mhs_nama', 'like', "%{$search}%")
                                ->orWhere('semester', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Agar pagination tetap membawa parameter search

        return view("admin.admin-dashboard", compact('skripsi'));
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
