<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswa';

    protected $primaryKey = 'nis';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'nis',
        'kelas_id',
        'nama_siswa',
        'no_hp',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nis_siswa', 'nis');
    }
}
