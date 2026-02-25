<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KelolaMahasiswaController;
use App\Http\Controllers\Admin\KelolaSkripsiController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use App\Http\Controllers\PercakapanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SkripsiController;
use Illuminate\Support\Facades\Route;

// Route::get('/login', function () {
//     return view('auth.login');
// });

// Route::get('/cari-skripsi', function () {
//     return view('base');
// })->name('base');

Route::get('/pencarian', [SearchController::class, 'index'])->name('base');
Route::get('/detail-skripsi/{id}', [SkripsiController::class, 'index'])->name('detail.skripsi');
Route::get('/download-hlm-depan/{id}', [SkripsiController::class, 'downloadHlmDepan'])->name('skripsi.download-hlm-depan');
Route::get('/download-bab1/{id}', [SkripsiController::class, 'downloadBab1'])->name('skripsi.download-bab1');

Route::get('/forum-diskusi', [PercakapanController::class, 'index'])->name('forum');
Route::get('/forum-diskusi/main-forum', [PercakapanController::class, 'mainForum'])->name('forum.utama');
Route::get('/forum-diskusi/skripsi/{id}', [PercakapanController::class, 'forumSkripsi'])->name('forum.skripsi');
Route::get('/forum-diskusi/thread/{id}', [PercakapanController::class, 'show'])->name('forum.thread');
Route::post('/forum-diskusi/store', [PercakapanController::class, 'store'])->name('forum.store');
Route::post('/forum-diskusi/reply', [PercakapanController::class, 'reply'])->name('forum.reply');
Route::put('/forum-diskusi/update/{id}', [PercakapanController::class, 'update'])->name('forum.update');
Route::delete('/forum-diskusi/delete/{id}', [PercakapanController::class, 'destroy'])->name('forum.destroy');


Route::middleware(['auth', 'Admin_adm'])->group(function () {
    Route::get('/admin/dashboard-kelola-skripsi', [AdminController::class, 'index'])->name('admin.dashboard'); 
    Route::get('/admin/tambah-skripsi/create', [KelolaSkripsiController::class, 'create'])->name('admin.tambah-skripsi.create'); 
    Route::post('/admin/store-skripsi/store', [KelolaSkripsiController::class, 'store'])->name('admin.tambah-skripsi.store'); 
    Route::get('/admin/edit-skripsi/edit/{id}', [KelolaSkripsiController::class, 'edit'])->name('admin.tambah-skripsi.edit');   
    Route::put('/admin/update-skripsi/update/{id}', [KelolaSkripsiController::class, 'update'])->name('admin.tambah-skripsi.update');
    Route::delete('/admin/hapus-skripsi/destroy/{id}', [KelolaSkripsiController::class, 'destroy'])->name('admin.tambah-skripsi.destroy'); 
    Route::get('/admin/detail-skripsi/detail/{id}', [KelolaSkripsiController::class, 'show'])->name('admin.detail-skripsi.show'); 
    Route::get('/admin/download-skripsi/{id}', [KelolaSkripsiController::class, 'download'])->name('admin.skripsi.download');
    Route::get('/admin/download-halaman-depan/{id}', [KelolaSkripsiController::class, 'downloadHlmDepan'])->name('admin.skripsi.download-hlm-depan');
    Route::get('/admin/download-bab1/{id}', [KelolaSkripsiController::class, 'downloadBab1'])->name('admin.skripsi.download-bab1');
    Route::get('/admin/kelola-mahasiswa', [KelolaMahasiswaController::class, 'index'])->name('admin.kelola-mahasiswa'); 
    Route::post('/admin/kelola-mahasiswa/import', [KelolaMahasiswaController::class, 'import'])->name('admin.kelola-mahasiswa.import'); 
    Route::delete('/admin/kelola-mahasiswa/destroy/{nim}', [KelolaMahasiswaController::class, 'destroy'])->name('admin.kelola-mahasiswa.destroy');  
    Route::delete('/admin/kelola-mahasiswa/destroy-all/', [KelolaMahasiswaController::class, 'destroyAll'])->name('admin.kelola-mahasiswa.destroy-all');  
   
}); 

Route::middleware(['auth', 'Mahasiswa_mhs'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('mhs.dashboard');  
    Route::get('/mahasiswa/tambah-skripsi/create', [MahasiswaController::class, 'create'])->name('mhs.skripsi.create'); 
    Route::post('mahasiswa/tambah-skripsi/store', [MahasiswaController::class, 'store'])->name('mhs.skripsi.store');
    Route::get('/mahasiswa/edit-skripsi/{id}', [MahasiswaController::class, 'edit'])->name('mhs.skripsi.edit');
    Route::put('/mahasiswa/update-skripsi/{id}', [MahasiswaController::class, 'update'])->name('mhs.skripsi.update');  
    Route::delete('/mahasiswa/hapus-skripsi/destroy/{id}', [MahasiswaController::class, 'destroy'])->name('mhs.skripsi.destroy');  
    Route::get('/mahasiswa/download-skripsi/{id}', [MahasiswaController::class, 'download'])->name('mhs.skripsi.download');
    Route::get('/mahasiswa/download-halaman-depan/{id}', [MahasiswaController::class, 'downloadHlmDepan'])->name('mhs.skripsi.download-hlm-depan');
    Route::get('/mahasiswa/download-bab1/{id}', [MahasiswaController::class, 'downloadBab1'])->name('mhs.skripsi.download-bab1');

}); 

require __DIR__.'/auth.php';


