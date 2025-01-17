<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    
    protected $table = 'pengembalian';
    
    protected $keyType = 'string';

    public $incrementing = false;

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

    public static function generateId()
    {
        $startId = 1;
        $latestData = Pengembalian::orderByDesc('id')->first();

        if ($latestData) {
            $isNewDate = date('Y-m') > date('Y-m', strtotime(substr($latestData['id'], 2, 6) . '01'));
    
            if (!$isNewDate) {
                $startId = (int) substr($latestData['id'], strlen('KBYYYYmm')) + 1;
            }
        }
        
        return 'KB' . date('Y') . date('m') . str_pad($startId, 5, 0, STR_PAD_LEFT);
    }
}
