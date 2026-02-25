<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percakapan extends Model
{
    use hasFactory;

    protected $table = 'percakapan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'isi_pesan', 
        'parent_id', 
        'user_id', 
        'skripsi_id', 
        'session_token',
        'nama_pengirim'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function skripsi(){
        return $this->belongsTo(Skripsi::class, 'skripsi_id', 'id');
    }

    public function replies(){
        return $this->hasMany(Percakapan::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Percakapan::class, 'parent_id');
    }
}
