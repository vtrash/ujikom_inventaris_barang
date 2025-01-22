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
        'batch_barang_id',
        'user_id',
        'nama_barang',
        'tgl_entry',
        'kondisi_barang',
        'status_dipinjam',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class, 'kode_jenis_barang', 'kode_jenis_barang');
    }

    public function batch_barang()
    {
        return $this->belongsTo(BatchBarang::class, 'batch_barang_id', 'id');
    }

    public function detail_peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'kode_barang', 'kode_barang');
    }
    
    public static function generateId()
    {
        $startId = 1;
        $latestData = BarangInventaris
            ::orderByDesc('kode_barang')
            ->lockForUpdate()
            ->first();

        if ($latestData) {
            $isNewDate = date('Y') > date('Y', strtotime($latestData->tgl_entry));
    
            if (!$isNewDate) {
                $startId = (int) substr($latestData['kode_barang'], 7) + 1;
            }
        }
        
        return 'INV' . date('Y') . str_pad($startId, 5, 0, STR_PAD_LEFT);
    }
}
