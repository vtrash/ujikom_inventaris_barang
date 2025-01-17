<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;
    
    protected $table = 'detail_peminjaman';
    
    protected $keyType = 'string';

    protected $incrementing = false;

    protected $fillable = [
        'id',
        'peminjaman_id',
        'kode_barang',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }

    public function barang_inventaris()
    {
        return $this->belongsTo(BarangInventaris::class, 'kode_barang', 'kode_barang');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'detail_peminjaman_id', 'id');
    }
}
