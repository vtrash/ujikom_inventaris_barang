<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::where('name', 'user')->first()->id;

        $siswaIds = Siswa::limit(5)->get()->pluck('nis');

        foreach ($siswaIds as $siswaId) {
            
            Peminjaman::create([
                'id' => Peminjaman::generateId(),
                'user_id' => $userId,
                'nis_siswa' => $siswaId,
                'tgl_peminjaman' => now(),
                'tgl_pengembalian' => date('Y-m-d 23:59:59', strtotime('+7 days')),
                'status_pengembalian' => '0'
            ]);
        }
    }
}
