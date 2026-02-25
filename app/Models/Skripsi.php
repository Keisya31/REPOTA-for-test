<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skripsi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'skripsi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul', 
        'abstrak', 
        'nim', 
        'nama_mhs',
        'nim_mhs',
        'path_file', 
        'tema', 
        'pembimbing', 
        'penguji_sidang', 
        'tanggal_sidang',];
    protected $casts = [
        'tanggal_sidang' => 'date'];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function percakapan(){
        return $this->hasMany(Percakapan::class, 'skripsi_id', 'id');
    }


}
