<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    
    protected $table = 'pengembalian';
    
    protected $keyType = 'string';

    protected $incrementing = false;

    protected $fillable = [
        'id',
        'detail_peminjaman_id',
        'user_id',
        'tgl_kembali',
        'kondisi_barang_kembali',
        'status_pengembalian',
    ];

    public function detail_peminjaman()
    {
        return $this->belongsTo(DetailPeminjaman::class, 'detail_peminjaman_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
