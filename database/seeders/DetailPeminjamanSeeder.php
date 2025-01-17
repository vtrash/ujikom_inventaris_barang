<?php

namespace Database\Seeders;

use App\Models\BarangInventaris;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peminjamanIds = Peminjaman
            ::orderByDesc('id')
            ->get()
            ->pluck('id');

        $barangIds = BarangInventaris
            ::orderByDesc('kode_barang')
            ->limit(sizeof($peminjamanIds) * 2)
            ->get()
            ->pluck('kode_barang');

        foreach ($peminjamanIds as $i => $peminjamanId) {
            for ($j = 0; $j < 2; $j++) {

                DB::beginTransaction();

                DetailPeminjaman::create([
                    'id' => DetailPeminjaman::generateId($peminjamanId),
                    'peminjaman_id' => $peminjamanId,
                    'kode_barang' => $barangIds[$i * 2 + $j],
                ]);

                BarangInventaris::find($barangIds[$i * 2 + $j])->update([
                    'status_dipinjam' => '1',
                ]);

                DB::commit();
            }
        }
    }
}