<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $keyType = 'string';

    protected $incrementing = 'false';

    protected $fillable = [
        'id',
        'user_id',
        'nis_siswa',
        'tgl_peminjaman',
        'tgl_pengembalian',
        'status_pengembalian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis');
    }

    public function detail_peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
}
