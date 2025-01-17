<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangInventaris extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang_inventaris';

    protected $primaryKey = 'kode_barang';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'kode_barang',
        'kode_jenis_barang',
        'user_id',
        'vendor_id',
        'nama_barang',
        'tgl_diterima',
        'tgl_entry',
        'kondisi_barang',
        'status_dipinjam',
        'no_entry',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class, 'kode_jenis_barang');
    }

    public function vendor_barang()
    {
        return $this->belongsTo(VendorBarang::class, 'vendor_id');
    }

    public function detail_peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'kode_barang');
    }
}
