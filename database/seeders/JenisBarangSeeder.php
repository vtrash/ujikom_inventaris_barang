<?php

namespace Database\Seeders;

use App\Models\JenisBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jeniss = ['Buku', 'Alat Elektronik', 'Alat Kebersihan'];

        foreach ($jeniss as $jenis) {
            JenisBarang::create([
                'kode_jenis_barang' => JenisBarang::generateId(),
                'jenis_barang' => $jenis
            ]);
        }
    }
}
