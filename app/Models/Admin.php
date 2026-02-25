<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'nip';
    protected $fillable = ['nip', 'adm_nama', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function percakapan(){
        return $this->hasMany(Percakapan::class, 'user_id', 'user_id');
    }

}
