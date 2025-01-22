<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';

    protected $keyType = 'string';

    public $incrementing = false;

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

    public static function generateId(string $peminjamanId, int $itemLength)
    {
        $startId = 1;

        $latestData = DetailPeminjaman
            ::where('peminjaman_id', $peminjamanId)
            ->orderByDesc('peminjaman_id')
            ->lockForUpdate()
            ->first();

        if ($latestData) {
            $startId = (int) substr($latestData['id'], strlen($peminjamanId)) + 1;
        }

        for ($i = 0; $i < $itemLength; $i++) {
            $generatedIds[] = $peminjamanId . str_pad($startId + $i, 3, 0, STR_PAD_LEFT);
        }

        return $generatedIds;

    }
}
