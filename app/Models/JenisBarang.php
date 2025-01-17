<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_barang';

    protected $primaryKey = 'kode_jenis_barang';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'kode_jenis_barang',
        'jenis_barang',
    ];

    public function barang_inventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'kode_jenis_barang', 'kode_jenis_barang');
    }
    public static function generateId()
    {
        $latestData = JenisBarang::orderByDesc('kode_jenis_barang')->first();

        $startId = $latestData ? (int) substr($latestData['kode_jenis_barang'], 2) + 1 : 1;

        return 'JB' . str_pad($startId, 5, 0, STR_PAD_LEFT);
    }
}
