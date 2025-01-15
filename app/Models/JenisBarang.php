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
        return $this->hasMany(BarangInventaris::class, 'kode_barang');
    }
}
