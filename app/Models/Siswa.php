<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswa';
    
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kelas_id',
        'jurusan_id',
        'nama_siswa',
        'nis',
        'no_hp',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'siswa_id');
    }
}
