<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBarang extends Model
{
    use HasFactory;
    
    protected $table = 'vendor_barang';
    
    protected $fillable = [
        'nama_vendor',
    ];

    public function batch_barang()
    {
        return $this->hasMany(BatchBarang::class, 'vendor_id', 'id');
    }
}
