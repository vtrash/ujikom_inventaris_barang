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

        foreach ($detailPeminjamanIds as $detailPeminjamanId) {
            Pengembalian::create([
                'id' => Pengembalian::generateId(),
                'detail_peminjaman_id' => $detailPeminjamanId,
                'status_pengembalian' => '0',
            ]);
        }
    }
}
