<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBarang extends Model
{
    use HasFactory;
    
    protected $table = 'vendor_barang';
    
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_vendor',
    ];

    public function barang_inventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'vendor_id');
    }
}
