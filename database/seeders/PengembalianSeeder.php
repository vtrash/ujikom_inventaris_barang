<?php

namespace Database\Seeders;

use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengembalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detailPeminjamanIds = DetailPeminjaman::get()->pluck('id');

        $pengembalianIds = Pengembalian::generateId(count($detailPeminjamanIds));

        foreach ($detailPeminjamanIds as $index => $detailPeminjamanId) {
            Pengembalian::create([
                'id' => $pengembalianIds[$index],
                'detail_peminjaman_id' => $detailPeminjamanId,
                'status_pengembalian' => '0',
            ]);
        }
    }
}
