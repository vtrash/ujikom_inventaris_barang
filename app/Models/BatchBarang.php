<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchBarang extends Model
{
    use HasFactory;

    protected $table = 'batch_barang';

    protected $fillable = [
        'vendor_id',
        'tgl_diterima',
        'keterangan',
    ];

    public function vendor()
    {
        return $this->belongsTo(VendorBarang::class, 'vendor_id', 'id');
    }

    public function barang_inventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'batch_barang_id', 'id');
    }
}
