<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;


    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $fillable = ['nim', 'mhs_nama', 'status', 'semester', 'kelas', 'tugas_akhir'];

    public function user(){
        return $this->hasOne(User::class, 'mhs_nim', 'nim');
    }

    public function skripsi(){
        return $this->hasOne(Skripsi::class, 'nim', 'nim');
    }


}
