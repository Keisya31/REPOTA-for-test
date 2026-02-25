<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminUser = User::create([
            'username' => 'adminRepotaIF2025',
            'email' => 'repota_resmi@gmail.com',
            'password' => bcrypt('repotaforadmin123'),
            'role' => 'adm',
            'mhs_nim' => null,
        ]);

        // $mhsUser3 = User::create([
        //     'username' => 'mhsAkhir3',
        //     'email' => 'mhs_akhir3@gmail.com',
        //     'password' => bcrypt('repotaformhsakhir3900'),
        //     'role' => 'mhs',
        // ]);
        $mhsAsli1 = Mahasiswa::create([
            'nim' => '24060121140143',
            'mhs_nama' => 'Saffa Mutiara',
            'semester'=>'9',
            'tugas_akhir' => true,
        ]);
        
        User::create([
            'username' => 'mhsAsli1',
            'email' => 'mhs_akhir4@gmail.com',
            'password' => bcrypt('repotaformhsakhirasli1'),
            'role' => 'mhs',
            'mhs_nim' => $mhsAsli1->nim,
        ]);

        Admin::create([
            'nip' => '123456789012345678',
            'adm_nama' => 'Admin Test',
            'user_id' => $adminUser->id,
        ]);

        $mhsUser1 = Mahasiswa::create([
            'nim' => '24060122136534',
            'mhs_nama' => 'Mahasiswa Akhir(reg)',
            'semester'=>'7',
            'tugas_akhir' => true,
        ]);
        User::create([
            'username' => 'mhsAkhirRepota',
            'email' => 'mhs_akhir@gmail.com',
            'password' => bcrypt('repotaformhsakhir900'),
            'role' => 'mhs',
            'mhs_nim' => $mhsUser1->nim,
        ]);

        $mhsUser2 = Mahasiswa::create([
            'nim' => '24060122146534',
            'mhs_nama' => 'Mahasiswa Akhir 2(reg)',
            'semester'=>'7',
            'tugas_akhir' => true,
         
        ]);
        User::create([
            'username' => 'mhsAkhir1',
            'email' => 'mhs_akhir1@gmail.com',
            'password' => bcrypt('repotaformhsakhir2900'),
            'role' => 'mhs',
            'mhs_nim' => $mhsUser2->nim,
        ]);
        // Mahasiswa::create([
        //     'nim' => '24060122130011',
        //     'mhs_nama' => 'Mahasiswa Akhir 2(reg)',
        //     'semester'=>'9',
        //     'tugas_akhir' => true,
        //     'user_id' => $mhsUser2->id,
        // ]);
        $mhsUser3 = Mahasiswa::create([
            'nim' => '24060122120054',
            'mhs_nama' => 'Mahasiswa Akhir 3 (no reg)',
            'semester'=>'7',
            'tugas_akhir' => true,
            
        ]);
        // User::create([
        //     'username' => 'mhsAkhir2',
        //     'email' => 'mhs_akhir2@gmail.com',
        //     'password' => bcrypt('repotaformhsakhir3900'),
        //     'role' => 'mhs',
        //     'mhs_nim' => $mhsUser3->nim,
        // ]);
        // Mahasiswa::create([
        //     'nim' => '24060122140611',
        //     'mhs_nama' => 'Mahasiswa Akhir 3(reg)',
        //     'semester'=>'11',
        //     'tugas_akhir' => true,
        //     'user_id' => $mhsUser3->id,
        // ]);
        
        $mhsAsli2 = Mahasiswa::create([
            'nim' => '24060121140139',
            'mhs_nama' => 'Saputra Hasan',
            'semester'=>'9',
            'tugas_akhir' => true,
        ]);
        
        User::create([
            'username' => 'mhsAsli2',
            'email' => 'mhs_akhir5@gmail.com',
            'password' => bcrypt('repotaformhsakhirasli2'),
            'role' => 'mhs',
            'mhs_nim' => $mhsAsli2->nim,
        ]);

        // Mahasiswa::create([
        //     'nim' => '24060122140333',
        //     'mhs_nama' => 'Mahasiswa Akhir 5(no reg)',
        //     'semester'=>'7',
        //     'tugas_akhir' => true,
        // ]);

        Skripsi::create([
            'nim' => $mhsAsli1->nim,
            'nama_mhs'=> $mhsAsli1->mhs_nama,
            'nim_mhs' => $mhsAsli1->nim,
            'judul' => 'SISTEM REKOMENDASI PEMILIHAN HIJAB BUTTONSCARVES 
                    BERBASIS CONTENT-BASED IMAGE RETRIEVAL DENGAN MULTI
                    FEATURES DAN COSINE SIMILARITY ',
            'abstrak'=>'Industri fashion hijab di Indonesia terus berkembang pesat, dengan Buttonscarves sebagai 
salah satu brand premium yang dikenal memiliki koleksi hijab eksklusif. Seiring 
meningkatnya variasi desain hijab dan pakaian, kesesuaian visual antara keduanya menjadi 
faktor penting dalam menentukan pilihan konsumen. Namun, banyaknya variasi model, 
motif, dan warna sering menyulitkan konsumen untuk memilih hijab yang sesuai secara 
visual dengan pakaian yang dikenakan. Tantangan ini semakin besar pada era belanja daring, 
di mana keputusan pembelian sering kali hanya didasarkan pada gambar produk. Belum 
banyak penelitian yang secara khusus menggabungkan tiga jenis fitur visual, yaitu RGB 
Histogram, Local Binary Pattern, dan Canny Edge Detection dengan metode Cosine 
Similarity untuk membangun sistem rekomendasi hijab, khususnya pada brand 
Buttonscarves. Penelitian ini mengembangkan Content-Based Image Retrieval (CBIR) 
dengan pendekatan multi-features yang menggabungkan ketiga fitur visual tersebut, di mana 
proses rekomendasi dilakukan dengan menghitung Cosine Similarity antara vektor gambar 
pakaian yang diinputkan pengguna dan vektor gambar hijab dalam database untuk 
menghasilkan 10 rekomendasi hijab yang serupa secara visual dan relevan. Hasil pengujian 
menunjukkan sistem rekomendasi dapat mencapai nilai rata-rata precision sebesar 91% dari 
12 kategori query pakaian berdasarkan human evaluation, yang menunjukkan bahwa sistem 
mampu memberikan rekomendasi yang relevan dan tepat sasaran sistem yang dihasilkan 
diharapkan dapat mendukung konsumen dalam memilih hijab yang sesuai secara visual 
dengan pakaian mereka, terutama saat berbelanja secara daring. 
Kata kunci  : Content-Based Image Retrieval, RGB Histogram, Local Binary Pattern,  Canny 
Edge Detection, Cosine Similarity ',
            'path_file' => null,
            'tema' => 'siscer',
            'pembimbing_1' => 'Dr. Retno Kusumaningrum, S.Si., M.Kom.',
            'pembimbing_2' => 'Satriawan Rasyid Purnama, S.Kom., M.Cs.',
            'penguji_sidang' => 'Drs. Eko Adi Sarwoko. M.Komp.',
            'tanggal_sidang' => '2025-10-20',
        ]);

        Skripsi::create([
            'nim' =>  $mhsAsli2->nim,
            'nama_mhs'=> $mhsAsli2->mhs_nama,
            'nim_mhs' => $mhsAsli2->nim,
            'judul' => 'IMPLEMENTASI VGG-19 DENGAN PENDEKATAN RETINEX 
                    UNTUK KLASIFIKASI PENYAKIT TUBERCULOSIS ',
            'abstrak'=>'Tuberculosis (TBC) merupakan penyakit menular yang menjadi salah satu penyebab utama 
kematian di dunia dan memerlukan diagnosis yang cepat serta akurat untuk menekan angka 
penyebaran. Salah satu metode yang umum digunakan adalah pemeriksaan citra X-ray paru
paru karena lebih cepat dan murah dibanding pemeriksaan laboratorium, namun interpretasi 
manual masih sangat bergantung pada keahlian radiolog sehingga rawan kesalahan. Penelitian 
ini bertujuan mengembangkan sistem klasifikasi otomatis TBC menggunakan arsitektur VGG
19 dengan optimasi hyperparameter dan penerapan Multi-Scale Retinex (MSR) pada citra X
ray paru-paru. Dataset terdiri dari 2.283 citra dengan dua kelas, yaitu Normal (1.583) dan 
Tuberculosis (700), serta dilakukan augmentasi berupa rotasi acak 20°, zoom 20%, dan 
horizontal flip. Empat hyperparameter utama dieksplorasi, yaitu learning rate (10-3 dan 10-4), 
batch size (16 dan 32), dropout (0,3 dan 0,4), dan L2 regularization (10-3). Hasil penelitian 
menunjukkan konfigurasi terbaik terdapat pada learning rate 10-4, batch size 16, dan dropout 
0,3 dengan akurasi uji 99,71% baik pada model dengan maupun tanpa Retinex. Meskipun 
peningkatan akurasi numerik akibat Retinex tidak signifikan, analisis kurva akurasi dan loss 
menunjukkan bahwa model dengan Retinex lebih stabil dan mampu mengurangi overfitting. 
Dengan demikian, kombinasi optimasi hyperparameter, regularisasi, dan peningkatan kualitas 
citra terbukti efektif dalam meningkatkan performa VGG-19 untuk klasifikasi TBC berbasis 
X-ray. 
Kata kunci : Tuberculosis, VGG-19, Deep Learning, L2 Regularization, Retinex, X-ray.',
            'path_file' => null,
            'tema' => 'kv',
            'pembimbing_1' => 'Dr. Helmie Arif Wibawa, S.Si., M.Cs.',
            'pembimbing_2' => 'Sandy Kurniawan, S.Kom., M.Kom.',
            'penguji_sidang' => 'Dr. Indra Waspada. S.T., M.TI.',
            'tanggal_sidang' => '2025-09-30',
        ]);

       
    }
}
