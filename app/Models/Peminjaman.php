<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'nis_siswa',
        'tgl_peminjaman',
        'tgl_pengembalian',
        'status_pengembalian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis');
    }

    public function detail_peminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id', 'id');
    }

    public static function generateId()
    {
        $startId = 1;
        $latestData = Peminjaman
            ::orderByDesc('id')
            ->lockForUpdate()
            ->first();

        if ($latestData) {
            $isNewDate = date('Y-m') > date('Y-m', strtotime($latestData->tgl_peminjaman));
    
            if (!$isNewDate) {
                $startId = (int) substr($latestData['id'], 8) + 1;
            }
        }
        
        return 'PJ' . date('Y') . date('m') . str_pad($startId, 5, 0, STR_PAD_LEFT);
    }
}
